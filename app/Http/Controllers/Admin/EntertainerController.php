<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EntertainerDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;








class EntertainerController extends Controller
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
        return view('admin.entertainer.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =$request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $data = $request->only(['name', 'email', 'role', 'phone', 'password']);
            $data['role'] = 'entertainer';
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Entertainer Created sucessfully']);

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
        $data['entertainer']= EntertainerDetail::where('user_id',$id)->get();
        $data['user_id'] = $id;
        return view('admin.entertainer.Talent.index',compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entertainer=User::find($id);
        return view('admin.entertainer.edit',compact('entertainer'));
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

        $entertainer=User::find($id);

        $entertainer->name       =    $request->input('name');
        $entertainer->email      =    $request->input('email');
        $entertainer->phone      =    $request->input('phone');
        $entertainer->update();

        return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Entertainer Updated sucessfully']);
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
        return redirect()->back()->with(['status'=>true, 'message' => 'Entertainer Deleted sucessfully']);
    }

      /**
     * Show the form for creating a new Talent for Specific Entertainer.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTalentIndex($id)
    {
        $data['user_id'] = $id;
        return view('admin.entertainer.Talent.add',compact('data'));
    }
    public function storeTalent(Request $request,$id)

    {
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $data = $request->only(['title','user_id', 'category', 'price', 'description']);
            $data['user_id'] = $id;
            $user = EntertainerDetail::create($data);
            return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Talent Created sucessfully']);
        // return view('admin.entertainer.Talent.add');
    }
}
