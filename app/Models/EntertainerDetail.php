<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntertainerDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
// <<<<<<< Updated upstream

    public function User()
    {
// <<<<<<< Updated upstream
// =======
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function events(){
       return $this->belongsToMany('App\Model\Event','event_entertainers');
// >>>>>>> Stashed changes
    }
// =======
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
// >>>>>>> Stashed changes
    }
}
