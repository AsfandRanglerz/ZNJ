<?php

namespace App\Http\Controllers\Api;

use App\Models\Venue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VenueController extends Controller
{
    public  function getVenues(){
        $data=Venue::all();
        return $this->sendSuccess('Venue data',compact('data'));
    }
    public function getSingleVenue($id)
    {
        $data=Venue::find($id);
        if($data==null){
            return $this->sendError("Record Not Found!");
        }
        return $this->sendSuccess('Entertainer data',compact('data'));
    }
}
