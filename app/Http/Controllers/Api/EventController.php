<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventEntertainers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EventFeatureAdsPackage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public  function createEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'cover_image' => 'required',
            'location' => 'required',
            'about_event' => 'required',
            'event_type' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            'joining_type' => 'required',
            'price' => 'required',
            'description' => 'required',
            'hiring_entertainers_status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['title', 'location', 'about_event', 'event_type', 'date', 'to', 'joining_type', 'price', 'description']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('cover_image')) {
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/'), $filename);
            $data['cover_image'] = 'public/uploads/' . $filename;
        }
        Event::create($data);
        return $this->sendSuccess('Event created Successfully');
    }
    public function getEvents()
    {
        $event = Event::all();
        return $this->sendSuccess('Events', compact('event'));
    }
    public function userEvents()
    {
        $user_event = Event::where('user_id', auth()->id())->get();
        return $this->sendSuccess('user events', compact('user_event'));
    }
    public function getEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $event = Event::find($request->event_id)->get();
        return $this->sendSuccess('Event', compact('event'));
    }
    public function getEventEntertainers($id)
    {
        $data = EventEntertainers::where('event_id', $id)->get();
        return $this->sendSuccess('event entertainers', compact('data'));
    }
    public function updateEvent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'cover_image' => 'required',
            'location' => 'required',
            'about_event' => 'required',
            'event_type' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            'joining_type' => 'required',
            'price' => 'required',
            'description' => 'required',
            'hiring_entertainers_status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['title', 'location', 'about_event', 'event_type', 'date', 'to', 'joining_type', 'price', 'description']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('cover_image')) {
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/'), $filename);
            $data['cover_image'] = 'public/uploads/' . $filename;
        }
        Event::find($id)->update($data);
        $data = Event::find($id);
        return $this->sendSuccess('Event updated Successfully', compact('data'));
    }
    public function destroy($id)
    {
        $data = Event::find($id)->delete();
        return $this->sendSuccess('Event Delete Successfully');
    }
    public function getEventFeaturePackages()
    {
        $data = EventFeatureAdsPackage::get();
        return $this->sendSuccess('Event Ads Packages', compact('data'));
    }
    public function EventSelectPackage(Request $request){
        Event::where('user_id', Auth::id())->update([
            'event_feature_ads_packages_id' => $request->id,
        ]);
        $data = Event::where('user_id',Auth::id())->first();
        return $this->sendSuccess('Event Featured Request Successfully', compact('data'));
    }
}
