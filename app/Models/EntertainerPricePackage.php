<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntertainerPricePackage extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function entertainerDetails(){
       return $this->hasMany('App\Models\EntertainerDetail');
    }
}
