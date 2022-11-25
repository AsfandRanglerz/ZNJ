<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens,HasFactory,Notifiable;
    protected $guarded =[];
    public function entertainerDetail()
    {
        return $this->hasMany('App\Models\EntertainerDetail','user_id');
    }
    public function venues()
    {
        return $this->hasMany('App\Models\Venue','user_id');
    }
    public function events()
    {
        return $this->hasMany('App\Models\Event','user_id');
    }



}
