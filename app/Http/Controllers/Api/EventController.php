<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public  function createEvent(Request $request){

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
        $data=$request->only(['title','location','about_event','event_type','date','to','joining_type','price','description']);
        $data['user_id']=auth()->id();
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
    public function getEvents(){
        $event=Event::all();
        return $this->sendSuccess('Events',compact('event'));
    }
    public function userEvents(){
        $user_event=Event::where('user_id',auth()->id())->get();
        return $this->sendSuccess('user events',compact('user_event'));
    }
    public function getEvent(Request $request){
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $event=Event::find($request->event_id)->get();
        return $this->sendSuccess('Event',compact('event'));
    }
}
