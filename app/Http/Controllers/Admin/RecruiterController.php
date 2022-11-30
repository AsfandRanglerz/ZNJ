<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;
use App\Models\EntertainerDetail;
use App\Mail\UserLoginPassword;
use Illuminate\Support\Facades\Mail;

class RecruiterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.recruiter.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'phone' => 'required',
            // 'password' => 'required|confirmed',
            // 'password_confirmation' => 'required',
            'company' => 'required',
            'designation' => 'required'

        ]);

        $data = $request->only(['name', 'email', 'role', 'phone', 'company', 'designation']);
        $data['role'] = 'recruiter';
        $messages['password'] = random_int(10000000, 99999999);
        $messages['email'] = $request->email;
        $data['password'] = Hash::make($messages['password']);
        try {
        Mail::to($request->email)->send(new UserLoginPassword($messages));
        $user = User::create($data);
            return redirect()->route('admin.user.index')->with(['status' => true, 'message' => 'Recruiter Created successfully']);
        } catch (\Throwable $th) {
            return $this->sendError('Something Went Wrong');
        }
    }
    /**
     *  Showing Recruiter Event
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $data['recruiter_event'] = Event::where('user_id', $user_id)->get();
        $data['user_id'] = $user_id;
        return view('admin.recruiter.event.index', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {

        $recruiter = User::find($user_id);
        return view('admin.recruiter.edit', compact('recruiter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'company' => 'required',
            'designation' => 'required'

        ]);
        $recruiter = User::find($user_id);
        $recruiter->name   = $request->input('name');
        $recruiter->email  = $request->input('email');
        $recruiter->phone  = $request->input('phone');
        $recruiter->company= $request->input('company');
        $recruiter->designation=   $request->input('designation');
        $recruiter->update();

        return redirect()->route('admin.user.index')->with(['status' => true, 'message' => 'Recruiter Updated sucessfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with(['status' => true, 'message' => 'Recruiter Deleted sucessfully']);
    }
    public function editEventIndex($event_id)
    {
        // dd($user_id,$event_id);
        $data['recruiter_event'] = Event::find($event_id);
        // $data['user_id'] = $id;

        return view('admin.recruiter.event.edit', compact('data'));
    }
    public function updateEvent(Request $request, $event_id)
    {
        $request->validate([
            'title' => 'required',
            // 'cover_image' => 'required',
            // 'location' => 'required',
            'about_event' => 'required',
            'description' => 'required',
            'price' => 'required',
            'event_type' => 'required',
            'joining_type' => 'required',
            'hiring_entertainers_status' => 'required',
            'seats' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);
        $recruiter = Event::find($event_id);
        $recruiter->title = $request->title;
        $recruiter->about_event = $request->about_event;
        $recruiter->description  = $request->description;
        $recruiter->price = $request->price;
        $recruiter->event_type = $request->event_type;
        $recruiter->joining_type = $request->joining_type;
        $recruiter->hiring_entertainers_status = $request->hiring_entertainers_status;
        $recruiter->seats = $request->seats;
        $recruiter->date = $request->date;
        $recruiter->from = $request->from;
        $recruiter->to = $request->to;
        $recruiter->update();
        return redirect()->route('recruiter.show',$recruiter->user_id)->with(['status' => true, 'message' => 'Event Updated sucessfully']);
    }
    public function createEventIndex($user_id){
        $data['user_id'] = $user_id;
        return view('admin.recruiter.event.add',compact('data'));
    }
    public function storeEvent(Request $request,$user_id){
        $request->validate([
            'title' => 'required',
            // 'cover_image' => 'required',
            // 'location' => 'required',
            'about_event' => 'required',
            'description' => 'required',
            'price' => 'required',
            'event_type' => 'required',
            'joining_type' => 'required',
            'hiring_entertainers_status' => 'required',
            'seats' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);
        $data=$request->only(['title','user_id','about_event','description','price','event_type','joining_type','hiring_entertainers_status','seats','date','from','to']);
        $data['user_id']=$user_id;
        Event::create($data);
        return redirect()->route('recruiter.show',$user_id)->with(['status' => true, 'message' => 'Event Added successfully']);
    }
    public function eventEntertainersIndex($event_id){
       $data['event_entertainers']= Event::find($event_id)->entertainerDetails;
    //   dd($data['event_entertainers']);
        return view('admin.recruiter.event.event_entertainers',compact('data'));
    }
    public function eventVenuesIndex($event_id){
        $data['event_venues']= Event::find($event_id)->eventVenues;
         return view('admin.recruiter.event.event_venues',compact('data'));
     }


}
