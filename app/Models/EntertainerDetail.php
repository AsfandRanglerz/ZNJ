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
