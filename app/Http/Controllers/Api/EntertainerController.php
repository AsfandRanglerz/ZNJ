<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EntertainerDetail;
use App\Models\EntertainerEventPhotos;
use App\Models\EntertainerPricePackage;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntertainerController extends Controller
{
    public function createEntertainer(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'location' => 'required',
            'title' => 'required',
            'image' => 'required',
            'about_yourself' => 'required',
            'category' => 'required',
            'price' => 'required',
            'event_photos' => 'required',
            'description' => 'required',
            'time' => 'required',
            'price_package' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['location', 'title', 'about_yourself', 'category', 'price', 'description']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/'), $filename);
            $data['image'] = 'public/uploads/' . $filename;
        }
        $data['user_id'] = auth()->id();

        $entertainer = EntertainerDetail::create($data);

        if ($request->hasfile('event_photos')) {
            $file = $request->file('event_photos');
            foreach ($file as $file) {
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = time() . '.' . $extension;
                $file->move(public_path('/'), $filename);
                $photos = [
                    'entertainer_details_id' => $entertainer->id,
                    'event_photos' => 'public/uploads/' . $filename,
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
        $data=EntertainerDetail::find($entertainer->id);
        return $this->sendSuccess('Event created Successfully',compact('data'));
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
            'title' => 'required',
            'image' => 'required',
            'about_yourself' => 'required',
            'category' => 'required',
            'price' => 'required',
            'event_photos' => 'required',
            'description' => 'required',
            'time' => 'required',
            'price_package' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['location', 'title', 'about_yourself', 'category', 'price', 'description']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/'), $filename);
            $data['image'] = 'public/uploads/' . $filename;
        }
        $data['user_id'] = auth()->id();
        $entertainer = EntertainerDetail::find($id)->update($data);
        EntertainerEventPhotos::where('entertainer_details_id', $id)->delete();
        if ($request->hasfile('event_photos')) {
            $file = $request->file('event_photos');
            foreach ($file as $file) {
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = time() . '.' . $extension;
                $file->move(public_path('/'), $filename);
                $photos = [
                    'entertainer_details_id' => $id,
                    'event_photos' => 'public/uploads/' . $filename,
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
}
