<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Mail\JoinEvent;
use App\Models\EventVenue;
use App\Models\EventTicket;
use Illuminate\Http\Request;
use App\Models\EntertainerDetail;
use App\Models\EventEntertainers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\EventFeatureAdsPackage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function entertainer_tallents()
    {
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
        $data = $request->only(['title', 'location', 'about_event', 'event_type', 'date', 'from', 'to', 'joining_type', 'price', 'description', 'seats']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('cover_image')) {
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('images'), $filename);
            $data['cover_image'] = 'public/images/' . $filename;
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
        $data = Event::with('entertainerDetails', 'eventVenues')->find($event->id);
        return $this->sendSuccess('Event created Successfully', $data);
    }
    public function getEvents()
    {
        $event = Event::all();
        return $this->sendSuccess('Events', compact('event'));
    }
    public function userEvents()
    {
        $user_event = Event::with('User', 'reviews.user')->where('user_id', auth()->id())->get();
        // $user_event = Event::join('users', 'events.user_id', '=', 'users.id')->where('user_id', auth()->id())->get(['events.*', 'users.name','users.image']);
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
        $data = $request->only(['title', 'location', 'about_event', 'event_type', 'date', 'from', 'to', 'joining_type', 'price', 'description']);
        $data['user_id'] = auth()->id();
        if ($request->hasfile('cover_image')) {
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('images'), $filename);
            $data['cover_image'] = 'public/images/' . $filename;
        }
        $event = Event::find($id)->update($data);
        EventEntertainers::where('event_id', $id)->delete();
        if (isset($request->entertainer_details_id)) {
            for ($i = 0; $i < count($request->entertainer_details_id); $i++) {
                $event_entertainer = new EventEntertainers;
                $event_entertainer->event_id = $id;
                $event_entertainer->entertainer_details_id = $request->entertainer_details_id[$i];
                $event_entertainer->save();
            }
        }
        if (isset($request->venues_id)) {
            EventVenue::where('event_id', $id)->update([
                'venues_id' => $request->venues_id,
            ]);
        }
        $data = Event::with('entertainerDetails', 'eventVenues')->find($id);
        return $this->sendSuccess('Event updated Successfully', compact('data'));
    }
    public function delete_event($id)
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
        $last_record = EventTicket::orderby('id', 'DESC')->limit(1)->first();
        if (isset($last_record)) {
            $ticket = EventTicket::where('user_id', Auth::id())->where('event_id', $request->event_id)->first();
            if (isset($ticket)) {
                return $this->sendError('You already have purchased ticket for this event');
            } else {
                $data = $request->only(['name', 'surname', 'age', 'ticket_type', 'gender', 'phone', 'email']);
                $data['user_id'] = auth()->id();
                $data['event_id'] = $request->event_id;
                $data['serial_no'] = $last_record->serial_no + 1;
                if ($request->hasfile('photo')) {
                    $file = $request->file('photo');
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $filename = time() . '.' . $extension;
                    $file->move(public_path('images'), $filename);
                    $data['photo'] = 'public/images/' . $filename;
                }
                $dataa = EventTicket::create($data);
                Mail::to($dataa->User->email)->send(new JoinEvent($dataa));
                $data = EventTicket::find($dataa->id);
                return $this->sendSuccess('Event Ticket created Successfully', compact('data'));
            }
        } else {
            $ticket = EventTicket::where('user_id', Auth::id())->where('event_id', $request->event_id)->first();
            if (isset($ticket)) {
                return $this->sendError('You already have purchased ticket for this event');
            } else {
                $data = $request->only(['name', 'surname', 'age', 'ticket_type', 'gender', 'phone', 'email']);
                $data['user_id'] = auth()->id();
                $data['event_id'] = $request->event_id;
                $data['serial_no'] = 1;
                if ($request->hasfile('photo')) {
                    $file = $request->file('photo');
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $filename = time() . '.' . $extension;
                    $file->move(public_path('images'), $filename);
                    $data['photo'] = 'public/images/' . $filename;
                }
                $dataa = EventTicket::create($data);
                Mail::to($dataa->User->email)->send(new JoinEvent($dataa));
                $data = EventTicket::find($dataa->id);
                return $this->sendSuccess('Event Ticket created Successfully', compact('data'));
            }
        }
    }
    public function myBookingEvent()
    {
        $data = EventTicket::with('event')->where('user_id', Auth::id())->get();
        if (isset($data)) {
            return $this->sendSuccess('Booked event', compact('data'));
        } else {
            return $this->sendError('Record Not Found !');
        }
    }
    public function myBooking()
    {
        $data = Event::with('entertainerDetails', 'eventVenues')->where('user_id', Auth::id())->get();
        if (isset($data)) {
            return $this->sendSuccess('My Booking', compact('data'));
        } else {
            return $this->sendError('Record Not Found !');
        }
    }

}
