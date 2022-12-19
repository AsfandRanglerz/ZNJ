<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\EventVenue;
use App\Models\EventTicket;
use Illuminate\Http\Request;
use App\Models\EntertainerDetail;
use App\Models\EventEntertainers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EventFeatureAdsPackage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function entertainer_tallents(){
      $data = EntertainerDetail::with('User')->get();
      return $this->sendSuccess('Entertainers with Talent', compact('data'));
    }
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
            'seats' => 'required',
            'description' => 'required',
            'hiring_entertainers_status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['title', 'location', 'about_event', 'event_type', 'date', 'to', 'joining_type', 'price', 'description', 'seats']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('cover_image')) {
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/'), $filename);
            $data['cover_image'] = 'public/uploads/' . $filename;
        }
        $event = Event::create($data);
        if (isset($request->entertainer_details_id)) {
            for ($i = 0; $i < count($request->entertainer_details_id); $i++) {
                $event_entertainer = new EventEntertainers;
                $event_entertainer->event_id = $event->id;
                $event_entertainer->entertainer_details_id = $request->entertainer_details_id[$i];
                $event_entertainer->save();
            }
        }
        if (isset($request->venues_id)) {
            $event_venue = new EventVenue;
            $event_venue->event_id = $event->id;
            $event_venue->venues_id = $request->venues_id;
            $event_venue->save();
        }
        $data = Event::with('entertainerDetails','eventVenues')->find($event->id);
        return $this->sendSuccess('Event created Successfully', $data);
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
        $event=Event::find($id)->update($data);
        $data = Event::find($event->id);
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
    public function EventSelectPackage(Request $request)
    {
        Event::where('user_id', Auth::id())->update([
            'event_feature_ads_packages_id' => $request->id,
        ]);
        $data = Event::where('user_id', Auth::id())->first();
        return $this->sendSuccess('Event Featured Request Successfully', compact('data'));
    }
    public function joinEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $data = $request->only(['event_id', 'name', 'surname', 'age', 'ticket_type', 'serial_no', 'gender', 'phone', 'email']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/'), $filename);
            $data['photo'] = 'public/uploads/' . $filename;
        }
        $dataa = EventTicket::create($data);
        $data = EventTicket::find($dataa->id);
        return $this->sendSuccess('Event Ticket created Successfully', compact('data'));
    }
}
