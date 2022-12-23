<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use App\Models\TermCondition;
use App\Models\EntertainerDetail;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function HomePage()
    {
        $data['event'] = Event::with('User')->orderBy('avg_rating', 'DESC')->get();
        $data['entertainer'] = EntertainerDetail::with('User','reviews','talentCategory')->orderBy('avg_rating', 'DESC')->get();
        $data['venue'] = Venue::with('User','reviews','venueCategory','venuePhoto')->orderBy('avg_rating', 'DESC')->get();
        return $this->sendSuccess('Home Page Data', compact('data'));
    }
    public function topRatedEvents()
    {
        $data = Event::orderBy('avg_rating', 'DESC')->get();
        return $this->sendSuccess('Top rated events', compact('data'));
    }
    public function topRatedEntertainers()
    {
        $data = EntertainerDetail::orderBy('avg_rating', 'DESC')->get();
        return $this->sendSuccess('Top rated entertainers', compact('data'));
    }
    public function topRatedVenues()
    {
        $data = Venue::orderBy('avg_rating', 'DESC')->get();
        return $this->sendSuccess('Top rated venues', compact('data'));
    }
    public function terms()
    {
        $data = TermCondition::first();
        return $this->sendSuccess('Data sent  Successfully', compact('data'));
    }
}
