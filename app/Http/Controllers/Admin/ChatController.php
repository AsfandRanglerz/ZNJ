<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class ChatController extends Controller
{
    public function index(){
        $data['chat_users'] = User::all();
        return view('admin.Chat.index',compact('data'));
    }
    
}
