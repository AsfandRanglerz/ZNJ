<?php

namespace App\Http\Controllers\Api;

use App\Models\Venue;
use App\Models\VenuesPhoto;
use App\Models\VenuePricing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'category' => 'required',
            'about_venue' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required',
            'offer_cattering' => 'required',
            'epening_time' => 'required',
            'closing_time' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['title', 'category', 'about_venue', 'description', 'seats', 'stands', 'area(m2)', 'offer_cattering', 'epening_time', 'closing_time']);
        $data['user_id'] = auth()->id();
        // if ($request->hasfile('image')) {
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension(); // getting image extension
        //     $filename = time() . '.' . $extension;
        //     $file->move(public_path('/'), $filename);
        //     $data['image'] = 'public/uploads/' . $filename;
        // }
        // $data['user_id'] = auth()->id();

        $venue = Venue::create($data);
        if ($request->hasfile('photos')) {
            $file = $request->file('photos');
            foreach ($file as $file) {
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = time() . '.' . $extension;
                $file->move(public_path('/'), $filename);
                $photos = [
                    'venue_id' => $venue->id,
                    'photos' => 'public/uploads/' . $filename,
                ];
                VenuesPhoto::create($photos);
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
        return $this->sendSuccess('Venue created Successfully');
    }
    public function editVenue($id)
    {
        $data = Venue::find($id);
        return $this->sendSuccess('Venue data', compact('data'));
    }

    public function updateVenue(Request $request,$id){
        $data = $request->only(['title', 'category', 'about_venue', 'description', 'seats', 'stands', 'area(m2)', 'offer_cattering', 'epening_time', 'closing_time']);
        $venue=Venue::find($id)->update($data);
        // if ($request->hasfile('photos')) {
        //     $file = $request->file('photos');
        //     foreach ($file as $file) {
        //         $extension = $file->getClientOriginalExtension(); // getting image extension
        //         $filename = time() . '.' . $extension;
        //         $file->move(public_path('/'), $filename);
        //         $photos = [
        //             'venue_id' => $id,
        //             'photos' => 'public/uploads/' . $filename,
        //         ];
        //         VenuesPhoto::create($photos);
        //     }
        // }
        for ($i = 0; $i < count($request->photos); $i++) {
            $image = $request->file('photos' . $i);
            $filename = hexdec(uniqid()) . '.' . strtolower($image->getClientOriginalExtension());
            // $filename = $image->getClientOriginalName();
            $image->move('public/image/product/', $filename);
            $file = asset('public/image/product/' . $filename);
            VenuesPhoto::updateOrCreate([
                'venue_id' => $id,
                'photos' => $file,
            ]);
        }
        VenuePricing::where('venues_id',$id)->delete();
        for ($i = 0; $i < count($request->day); $i++) {
            $data = [
                'venues_id'  => $id,
                'day'  => $request->day[$i],
                'price'  => $request->price[$i],
            ];
            VenuePricing::create($data);
        }
        $venue=Venue::find($id);
        return $this->sendSuccess('Venue Updated Successfully',compact('venue'));
    }

    public function destroy($id)
    {
        $data = Venue::find($id)->delete();
        return $this->sendSuccess('Venue Delete Successfully');
    }

}
