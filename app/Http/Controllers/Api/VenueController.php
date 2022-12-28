<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Venue;
use App\Mail\BookVenues;
use App\Models\BookVenue;
use App\Models\VenuesPhoto;
use App\Models\VenuePricing;
use Illuminate\Http\Request;
use App\Models\VenueCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\VenueFeatureAdsPackage;
use Illuminate\Support\Facades\Validator;

class VenueController extends Controller
{
    public  function getVenues()
    {
        $data = Venue::with('User', 'reviews', 'venueCategory', 'venuePhoto', 'venuePricing')->get();
        return $this->sendSuccess('Venue data', compact('data'));
    }
    public function getSingleVenue($id)
    {
        $data = User::with('venues', 'venues.venueCategory', 'venues.venuePhoto', 'venues.venuePricing', 'venues.reviews')->find($id);
        if ($data == null) {
            return $this->sendError("Record Not Found!");
        }
        return $this->sendSuccess('Entertainer data', compact('data'));
    }

    public function createVenue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required',
            'about_venue' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required',
            // 'opening_time' => 'required',
            // 'closing_time' => 'required',
            // 'amenities' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['title', 'category_id', 'about_venue', 'description', 'seats', 'stands', 'area']);
        $data['user_id'] = auth()->id();
        if (isset($request->amenities)) {
            $data['amenities'] = implode(',', $request->amenities);
        }
        // if ($request->hasfile('image')) {
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension(); // getting image extension
        //     $filename = time() . '.' . $extension;
        //     $file->move(public_path('/'), $filename);
        //     $data['image'] = 'public/uploads/' . $filename;
        // }
        // $data['user_id'] = auth()->id();
        $venue = Venue::create($data);
        if ($request->file('photos')) {
            foreach ($request->file('photos') as $data) {
                $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                $data->move(public_path('images'), $image);
                VenuesPhoto::create([
                    'photos' =>  'public/images/' . $image,
                    'venue_id' => $venue->id
                ]);
            }
        }
        if (isset($request->day)) {
            for ($i = 0; $i < count($request->day); $i++) {
                $data = [
                    'venues_id'  => $venue->id,
                    'day'  => $request->day[$i],
                    'price'  => $request->price[$i],
                    'opening_time' => $request->opening_time[$i],
                    'closing_time' => $request->closing_time[$i],
                ];
                VenuePricing::create($data);
            }
        }
        $data = Venue::with('User', 'reviews', 'venueCategory', 'venuePhoto', 'venuePricing')->find($venue->id);
        return $this->sendSuccess('Venue created Successfully', compact('data'));
    }
    public function editVenue($id)
    {
        $data = Venue::with('User', 'reviews', 'venueCategory', 'venuePhoto', 'venuePricing')->find($id);
        return $this->sendSuccess('Venue data', compact('data'));
    }
    public function updateVenue(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required',
            'about_venue' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required',
            // 'opening_time' => 'required',
            // 'closing_time' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['title', 'category_id', 'about_venue', 'description', 'seats', 'stands', 'area']);
        $data['amenities'] = implode(',', $request->amenities);
        $venue = Venue::find($id)->update($data);
        VenuesPhoto::where('venue_id', $id)->delete();
        if ($request->file('photos')) {
            foreach ($request->file('photos') as $data) {
                $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                $data->move(public_path('images'), $image);
                VenuesPhoto::create([
                    'photos' =>  'public/images/' . $image,
                    'venue_id' => $id
                ]);
            }
        }
        if (isset($request->day)) {
            VenuePricing::where('venues_id', $id)->delete();
            for ($i = 0; $i < count($request->day); $i++) {
                $data = [
                    'venues_id'  => $id,
                    'day'  => $request->day[$i],
                    'price'  => $request->price[$i],
                    'opening_time' => $request->opening_time[$i],
                    'closing_time' => $request->closing_time[$i],
                ];
                VenuePricing::create($data);
            }
        }
        $venue = Venue::with('User', 'reviews', 'venueCategory', 'venuePhoto', 'venuePricing')->find($id);
        return $this->sendSuccess('Venue Updated Successfully', compact('venue'));
    }

    public function destroy($id)
    {
        $data = Venue::find($id)->delete();
        return $this->sendSuccess('Venue Delete Successfully');
    }
    public function getVenueFeaturePackages()
    {
        $data = VenueFeatureAdsPackage::get();
        return $this->sendSuccess('Venue Ads Packages', compact('data'));
    }
    public function VenueSelectPackage(Request $request)
    {
        Venue::where('user_id', Auth::id())->update([
            'venue_feature_ads_packages_id' => $request->id,
        ]);
        $data = Venue::with('User', 'reviews', 'venueCategory', 'venuePhoto', 'venuePricing')->where('user_id', Auth::id())->first();
        return $this->sendSuccess('Venue Featured Request Successfully', compact('data'));
    }
    public function venue_category()
    {
        $data = VenueCategory::get();
        return $this->sendSuccess('Venue Categories', compact('data'));
    }
    public function book_venue(Request $request)
    {
        $book_venue = BookVenue::where('user_id', Auth::id())->where('venue_id', $request->venue_id)->first();
        if (isset($book_venue)) {
            return $this->sendError('Already request send');
        } else {
            $data = new BookVenue();
            $data->user_id = Auth::id();
            $data->venue_id = $request->venue_id;
            $data->date = $request->date;
            $data->seats = $request->seats;
            $data->from = $request->from;
            $data->to = $request->to;
            $data->save();
            Mail::to($data->venue->User->email)->send(new BookVenues($data));
            return $this->sendSuccess('Venue Book successfully', compact('data'));
        }
    }
    public function venue_reviews($id){
        $data=Venue::with('User','reviews.user')->find($id);
        return $this->sendSuccess('Venue reviews',compact('data'));
    }
}
