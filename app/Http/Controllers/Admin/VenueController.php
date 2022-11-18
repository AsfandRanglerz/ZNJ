<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class VenueController extends Controller
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
        return view('admin.venue_provider.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $data = $request->only(['name', 'email', 'role', 'phone', 'password']);
            $data['role'] = 'venue';
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Venue Provider Created sucessfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         //  Showing Entertainer Talent

         $data['venue']= Venue::where('user_id',$id)->get() ;
         $data['user_id']=$id;
         return view('admin.venue_provider.venues.index',compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venue=User::find($id);
        return view('admin.venue_provider.edit',compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
           $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',

    ]);
        $recruiter=User::find($id);

        $recruiter->name       =    $request->input('name');
        $recruiter->email      =    $request->input('email');
        $recruiter->phone      =    $request->input('phone');
        $recruiter->venue      =    $request->input('venue');
        $recruiter->update();

        return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Venue Updated sucessfully']);
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
        return redirect()->back()->with(['status'=>true, 'message' => 'Venue Deleted sucessfully']);
    }

    public function createVenueIndex($id)
    {
        $data['user_id'] = $id;
        return view('admin.venue_provider.venues.add',compact('data'));
    }
    public function storeVenue(Request $request,$id)

    {
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required',
            // 'offer cattering' => 'required',
            // 'opening time' =>'required',
            // 'closing time' =>'required'


        ]);

        $data = $request->only(['title','user_id', 'category', 'description','seats','stands','offer_cattering','epening_time','closing_time']);
            $data['user_id'] = $id;
            $user = Venue::create($data);
            return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Venue Created sucessfully']);
        // return view('admin.entertainer.Talent.add');
    }
}
