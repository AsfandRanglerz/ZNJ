<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use App\Models\VenueCategory;
use App\Models\TalentCategory;
use App\Models\EntertainerDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function searchData(Request $request)
    {
        $data['events'] = Event::where('title', 'like', '%' . $request->search . '%')->get();
        // $data['entertainers'] = EntertainerDetail::where('title', 'like', '%' . $request->search . '%')->get();
        $data['entertainers'] = TalentCategory::with('entertainerDetail')->where('category', 'like', '%' . $request->search . '%')->get();
        // $data['venues'] = Venue::where('title', 'like', '%' . $request->search . '%')->get();
        $data['venues'] = VenueCategory::with('Venue')->where('category', 'like', '%' . $request->search . '%')->get();
        return $this->sendSuccess('Success', compact('data'));
    }

    public function searchFilter(Request $request)
    {
        if ($request->type == 'entertainer') {
            // $data['entertainers'] = EntertainerDetail::where('title', 'like', '%' . $request->search . '%')->get();
            $data['entertainers'] = TalentCategory::with('entertainerDetail')->where('category', 'like', '%' . $request->search . '%')->get();
            return $this->sendSuccess('Success', compact('data'));
        } elseif ($request->type == 'event') {
            $data['events'] = Event::where('title', 'like', '%' . $request->search . '%')->get();
            return $this->sendSuccess('Success', compact('data'));
        } elseif ($request->type == 'venue') {
            // $data['venues'] = Venue::where('title', 'like', '%' . $request->search . '%')->get();
            $data['venues'] = VenueCategory::with('Venue')->where('category', 'like', '%' . $request->search . '%')->get();
            return $this->sendSuccess('Success', compact('data'));
        } else {
            $data['events'] = Event::where('title', 'like', '%' . $request->search . '%')->get();
            $data['entertainers'] = TalentCategory::with('entertainerDetail')->where('category', 'like', '%' . $request->search . '%')->get();
            $data['venues'] = VenueCategory::with('Venue')->where('category', 'like', '%' . $request->search . '%')->get();
            return $this->sendSuccess('Success', compact('data'));
        }
    }
    public function myAdsFilter(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user->role == 'entertainer') {
            // $data = EntertainerDetail::where('user_id', Auth::id())->where('title', 'like', '%' . $request->search . '%')->get();
            $data['entertainers'] = TalentCategory::with('entertainerDetail')->where('category', 'like', '%' . $request->search . '%')->get();

            return $this->sendSuccess('Success', compact('data'));
        } elseif ($user->role == 'event') {
            $data = Event::where('user_id', Auth::id())->where('title', 'like', '%' . $request->search . '%')->get();
            return $this->sendSuccess('Success', compact('data'));
        } elseif ($user->role == 'venue') {
            // $data = Venue::where('user_id', Auth::id())->where('title', 'like', '%' . $request->search . '%')->get();
            $data['venues'] = VenueCategory::with('Venue')->where('category', 'like', '%' . $request->search . '%')->get();
            return $this->sendSuccess('Success', compact('data'));
        } else {
            return $this->sendError('Not Found!');
        }
    }
}
