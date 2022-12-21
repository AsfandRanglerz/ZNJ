<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\TalentCategory;
use App\Models\EntertainerDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EntertainerEventPhotos;
use App\Models\EntertainerPricePackage;
use Illuminate\Support\Facades\Validator;
use App\Models\EntertainerFeatureAdsPackage;

class EntertainerController extends Controller
{
    public function createEntertainer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required',
            // 'title' => 'required',
            'image' => 'required',
            'bio' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'event_photos' => 'required',
            'description' => 'required',
            'time' => 'required',
            // 'price_package' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['location', 'title', 'bio', 'category_id', 'price', 'description','own_equipment','shoe_size','waist','weight','height','awards']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('images'), $filename);
            $data['image'] = 'public/images/' . $filename;
        }
        // $data['user_id'] = auth()->id();
        $entertainer = EntertainerDetail::create($data);
        if ($request->hasfile('event_photos')) {
            $file = $request->file('event_photos');
            foreach ($file as $file) {
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = time() . '.' . $extension;
                $file->move(public_path('images'), $filename);
                $photos = [
                    'entertainer_details_id' => $entertainer->id,
                    'event_photos' => 'public/images/' . $filename,
                ];
                EntertainerEventPhotos::create($photos);
            }
        }

        for ($i = 0; $i < count($request->time); $i++) {
            $data = [
                'entertainer_details_id'  => $entertainer->id,
                'time'  => $request->time[$i],
                'price_package'  => $request->price_package[$i],
            ];

            EntertainerPricePackage::create($data);
        }
        $data = EntertainerDetail::with('entertainerEventPhotos','entertainerPricePackage')->find($entertainer->id);
        return $this->sendSuccess('Event created Successfully', compact('data'));
    }
    public  function getEntertainer()
    {
        $data = EntertainerDetail::all();
        return $this->sendSuccess('Entertainer data', compact('data'));
    }
    public function getSingleEntertainer($id)
    {
        $data = EntertainerDetail::find($id);
        if ($data == null) {
            return $this->sendError("Record Not Found!");
        }
        return $this->sendSuccess('Entertainer data', compact('data'));
    }

    public function updateEntertainer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required',
            // 'title' => 'required',
            'image' => 'required',
            'bio' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'event_photos' => 'required',
            'description' => 'required',
            'time' => 'required',
            'price_package' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['location', 'title', 'bio', 'category_id', 'price', 'description','own_equipment','shoe_size','waist','weight','height','awards']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('images'), $filename);
            $data['image'] = 'public/images/' . $filename;
        }
        $data['user_id'] = auth()->id();
        $entertainer = EntertainerDetail::find($id)->update($data);
        EntertainerEventPhotos::where('entertainer_details_id', $id)->delete();
        if ($request->hasfile('event_photos')) {
            $file = $request->file('event_photos');
            foreach ($file as $file) {
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = time() . '.' . $extension;
                $file->move(public_path('images'), $filename);
                $photos = [
                    'entertainer_details_id' => $id,
                    'event_photos' => 'public/images/' . $filename,
                ];
                EntertainerEventPhotos::create($photos);
            }
        }
        EntertainerPricePackage::where('entertainer_details_id', $id)->delete();
        for ($i = 0; $i < count($request->time); $i++) {
            $data = [
                'entertainer_details_id'  => $id,
                'time'  => $request->time[$i],
                'price_package'  => $request->price_package[$i],
            ];

            EntertainerPricePackage::create($data);
        }
        $data = EntertainerDetail::find($id);
        return $this->sendSuccess('Entertainer updated Successfully', compact('data'));
    }
    public function getEntertainerPricePackage($id)
    {
        $data = EntertainerPricePackage::where('entertainer_details_id', $id)->get();
        if ($data == null) {
            return $this->sendError('Record Not Found!');
        }
        return $this->sendSuccess('Entertainer Price Package data', compact('data'));
    }
    public function getEntertainerFeaturePackages()
    {
        $data = EntertainerFeatureAdsPackage::get();
        return $this->sendSuccess('Entertainer Ads Packages', compact('data'));
    }
    public function EntertainerSelectPackage(Request $request){
        EntertainerDetail::where('user_id', Auth::id())->update([
            'entertainer_feature_ads_packages_id' => $request->id,
        ]);
        $data = EntertainerDetail::where('user_id',Auth::id())->first();
        return $this->sendSuccess('Entertainer Featured Request Successfully', compact('data'));
    }
    public function talentCategory(){
    $data  =  TalentCategory::get();
    return $this->sendSuccess('Talent Categories', compact('data'));
    }
}
