<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function index(){
        $data['recruiter']=User::where('role','recruiter')->with(['events' => function ($query) {$query->select('user_id','title'); }])->latest()->get();
        $data['venue']=User::where('role','venue')->with(['venues' => function ($query) {$query->select('user_id','category'); }])->latest()->get();
        $data['entertainer']=User::where('role','entertainer')->with(['entertainerDetail' => function ($query) {$query->select('user_id','category'); }])->latest()->get();
        // dd(implode(',',$data['entertainer'][0]['EntertainerDetail']));



        return view('admin.users.index',['data'=>$data]);


    }
}
