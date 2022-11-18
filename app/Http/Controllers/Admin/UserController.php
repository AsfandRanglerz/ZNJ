<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $data['recruiter']=User::where('role','Recruiter')->get();
        $data['venue']=User::where('role','venue')->with(['venues' => function ($query) {$query->select('user_id','category'); }])->get();
        $data['entertainer']=User::where('role','entertainer')->with(['entertainerDetail' => function ($query) {$query->select('user_id','category'); }])->get();
        // dd(implode(',',$data['entertainer'][0]['EntertainerDetail']));



        return view('admin.users.index',['data'=>$data]);


    }
}
