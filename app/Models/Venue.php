<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function User()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function venueFeatureAdsPackage ()
    {
        return $this->belongsTo('App\Models\VenueFeatureAdsPackage','venue_feature_ads_packages_id','id');
    }
    public function events(){
        return $this->belongsToMany('App\Models\Event','event_venues','venues_id','event_id');
     }
}
