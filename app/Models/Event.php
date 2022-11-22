<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function entertainerDetails(){
        return $this->belongsToMany('App\Model\EntertainerDetail','event_entertainers');
     }
     public function User()
     {
         return $this->hasMany('App\Models\User','user_id','id');
     }
    public function getCoverImageAttribute($path)
    {
        if ($path){
            return asset($path);
        }else{
            return null;
        }
    }
}
