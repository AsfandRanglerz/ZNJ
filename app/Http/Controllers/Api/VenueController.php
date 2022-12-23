<?php

namespace App\Http\Controllers\Api;

use App\Models\Venue;
use App\Models\VenuesPhoto;
use App\Models\VenuePricing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\VenueFeatureAdsPackage;
use Illuminate\Support\Facades\Validator;

class VenueController extends Controller
{
    public  function getVenues()
    {
        $data = Venue::all();
        return $this->sendSuccess('Venue data', compact('data'));
    }
    public function getSingleVenue($id)
    {
        $data = Venue::find($id);
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
            'opening_time' => 'required',
            'closing_time' => 'required',
            'amenities' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['title', 'category_id', 'about_venue', 'description', 'seats', 'stands', 'area(m2)', 'opening_time', 'closing_time']);
        $data['user_id'] = auth()->id();
        $data['amenities'] = implode(',', $request->amenities);
        // if ($request->hasfile('image')) {
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension(); // getting image extension
        //     $filename = time() . '.' . $extension;
        //     $file->move(public_path('/'), $filename);
        //     $data['image'] = 'public/uploads/' . $filename;
        // }
        // $data['user_id'] = auth()->id();
        $venue = Venue::create($data);
        // if ($request->hasfile('photos')) {
        //     $file = $request->file('photos');
        //     foreach ($file as $file) {
        //         $extension = $file->getClientOriginalExtension(); // getting image extension
        //         $filename = time() . '.' . $extension;
        //         $file->move(public_path('images'), $filename);
        //         $photos = [
        //             'venue_id' => $venue->id,
        //             'photos' => 'public/uploads/' . $filename,
        //         ];
        //         VenuesPhoto::create($photos);
        //     }
        // }
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
        for ($i = 0; $i < count($request->day); $i++) {
            $data = [
                'venues_id'  => $venue->id,
                'day'  => $request->day[$i],
                'price'  => $request->price[$i],
            ];
            VenuePricing::create($data);
        }
        $data=Venue::find($venue->id);
        return $this->sendSuccess('Venue created Successfully',compact('data'));
    }
    public function editVenue($id)
    {
        $data = Venue::find($id);
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
            'opening_time' => 'required',
            'closing_time' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['title', 'category_id', 'about_venue', 'description', 'seats', 'stands', 'area(m2)', 'opening_time', 'closing_time']);
        $data['amenities'] = implode(',', $request->amenities);
        $venue = Venue::find($id)->update($data);
        VenuesPhoto::where('venue_id', $id)->delete();
        if ($request->hasfile('photos')) {
            $file = $request->file('photos');
            foreach ($file as $file) {
                $extension = $file->getClientOriginalName(); // getting image extension
                $filename = time() . '.' . $extension;
                $file->move(public_path('images'), $filename);
                $photos = [
                    'venue_id' => $id,
                    'photos' => 'public/uploads/' . $filename,
                ];
                VenuesPhoto::create($photos);
            }
        }
        VenuePricing::where('venues_id', $id)->delete();
        for ($i = 0; $i < count($request->day); $i++) {
            $data = [
                'venues_id'  => $id,
                'day'  => $request->day[$i],
                'price'  => $request->price[$i],
            ];
            VenuePricing::create($data);
        }
        $venue = Venue::find($id);
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
    public function VenueSelectPackage(Request $request){
        Venue::where('user_id',Auth::id())->update([
            'venue_feature_ads_packages_id' => $request->id,
        ]);
        $data = Venue::where('user_id',Auth::id())->first();
        return $this->sendSuccess('Venue Featured Request Successfully', compact('data'));
    }
}
