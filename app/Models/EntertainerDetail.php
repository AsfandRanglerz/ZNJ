<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EntertainerDetail extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function User()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function events(){
       return $this->belongsToMany('App\Models\Event','event_entertainers','entertainer_details_id','event_id');
    }
    public function  entertainerEventPhotos(){
        return $this->hasMany('App\Models\EntertainerEventPhotos');
    }
    public function  entertainerPricePackage(){
        return $this->hasMany('App\Models\EntertainerPricePackage');
    }
    public function entertainerFeatureAdsPackage()
    {
        return $this->belongsTo('App\Models\EntertainerFeatureAdsPackage','entertainer_feature_ads_packages_id','id');
    }
    public function  talentCategory(){
        return $this->belongsTo('App\Models\TalentCategory','category_id','id');
    }
    public function getImageAttribute($path)
    {
        if ($path){
            return asset($path);
        }else{
            return null;
        }
    }
    public function getEventImageAttribute($path)
    {
        if ($path){
            return asset($path);
        }else{
            return null;
        }

    }
}
