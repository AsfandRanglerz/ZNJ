<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TermCondition;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function terms(){
        $data=TermCondition::first();
        return $this->sendSuccess('Data sent  Successfully', compact('data'));
    }
}
