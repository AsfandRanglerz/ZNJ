<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $data['venue']=User::where('role','Venue')->get();
        $data['recruiter']=User::where('role','Recruiter')->get();
        $data['entertainer']=User::where('role','Entertainer')->get();

        return view('admin.users.index',['data'=>$data]);


    }
}
