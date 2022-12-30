<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Event;
use App\Models\BookVenue;
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
            // 'event_photos' => 'required',
            'description' => 'required',
            // 'time' => 'required',
            // 'price_package' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['location', 'bio', 'category_id', 'price', 'description', 'own_equipment', 'shoe_size', 'waist', 'weight', 'height', 'awards']);
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
        if ($request->file('event_photos')) {
            foreach ($request->file('event_photos') as $data) {
                $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                $data->move(public_path('images'), $image);
                EntertainerEventPhotos::create([
                    'event_photos' =>  'public/images/' . $image,
                    'entertainer_details_id' => $entertainer->id
                ]);
            }
        }

        if (isset($request->time)) {
            for ($i = 0; $i < count($request->time); $i++) {
                $data = [
                    'entertainer_details_id'  => $entertainer->id,
                    'time'  => $request->time[$i],
                    'price_package'  => $request->price_package[$i],
                ];

                EntertainerPricePackage::create($data);
            }
        }
        $data = EntertainerDetail::with('entertainerEventPhotos', 'entertainerPricePackage')->find($entertainer->id);
        return $this->sendSuccess('Talent created Successfully', compact('data'));
    }
    public  function getEntertainer()
    {
        $data = EntertainerDetail::with('entertainerEventPhotos', 'entertainerPricePackage')->get();
        return $this->sendSuccess('Entertainer data', compact('data'));
    }
    public function getSingleEntertainer($id)
    {
        // , 'entertainerDetail.entertainerPricePackage'
        $data = User::with('entertainerDetail.entertainerEventPhotos', 'entertainerDetail.entertainerPricePackage', 'entertainerDetail.talentCategory')->find($id);
        if ($data == null) {
            return $this->sendError("Record Not Found!");
        }
        return $this->sendSuccess('Entertainer data', compact('data'));
    }

    public function updateEntertainer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required',
            'bio' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['location', 'bio', 'category_id', 'price', 'description', 'own_equipment', 'shoe_size', 'waist', 'weight', 'height', 'awards']);
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

        if ($request->file('event_photos')) {
            EntertainerEventPhotos::where('entertainer_details_id', $id)->delete();
            foreach ($request->file('event_photos') as $data) {
                $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                $data->move(public_path('images'), $image);
                EntertainerEventPhotos::create([
                    'event_photos' =>  'public/images/'.$image,
                    'entertainer_details_id' => $id
                ]);
            }
        }
        if (isset($request->time)) {
            EntertainerPricePackage::where('entertainer_details_id', $id)->delete();
            for ($i = 0; $i < count($request->time); $i++) {
                $data = [
                    'entertainer_details_id'  => $id,
                    'time'  => $request->time[$i],
                    'price_package'  => $request->price_package[$i],
                ];

                EntertainerPricePackage::create($data);
            }
        }
        $data = EntertainerDetail::with('entertainerEventPhotos', 'entertainerPricePackage')->find($id);
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
    public function EntertainerSelectPackage(Request $request)
    {
        EntertainerDetail::where('user_id', Auth::id())->update([
            'entertainer_feature_ads_packages_id' => $request->id,
        ]);
        $data = EntertainerDetail::where('user_id', Auth::id())->first();
        return $this->sendSuccess('Entertainer Featured Request Successfully', compact('data'));
    }
    public function talentCategory()
    {
        $data  =  TalentCategory::get();
        return $this->sendSuccess('Talent Categories', compact('data'));
    }
    public function delete_talent($id)
    {
        EntertainerDetail::destroy($id);
        return $this->sendSuccess('Entertainer deleted Successfully');
    }
    public function entertainer_reviews($id)
    {
        $data = EntertainerDetail::with('User', 'reviews.user')->find($id);
        return $this->sendSuccess('Entertainer reviews', compact('data'));
    }
    public function getSingleTalent($id)
    {
        $data = EntertainerDetail::with('entertainerEventPhotos', 'entertainerPricePackage','talentCategory','reviews.user')->find($id);
        if (isset($data)) {
            return $this->sendSuccess('Talent data', compact('data'));
        }else{
            return $this->sendError("Record Not Found!");
        }
    }
}
