<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Models\EntertainerDetail;
use App\Models\TalentCategory;

class UserController extends Controller
{
    public function index(){
        $data['recruiter']=User::where('role','recruiter')->with(['events' => function ($query) {$query->select('user_id','title'); }])->latest()->get();
        $data['venue']=User::where('role','venue_provider')->with(['venues' => function ($query) {$query->with('venueCategory'); }])->latest()->get();
        // $data['entertainer'] = TalentCategory::with('items')->get();
        $data['entertainer']=User::select('id','name','email','role','phone','created_at')->where('role','entertainer')->with(['entertainerDetail' => function ($query) {$query->with('talentCategory'); }])->latest()->get();
        // $data['entertainer']=TalentCategory::find(2)->user;
        // dd($data['entertainer']);
        // for ($i=0; $i < count($data['entertainer'][0]['entertainerDetail']) ; $i++) {
        //     $dat[] = json_decode($data['entertainer'][0]['entertainerDetail'][$i]['talentCategory'],true);
        //     implode(',',array_column($dat, 'category'));
        // }
        return view('admin.users.index',['data'=>$data]);
    }
}
