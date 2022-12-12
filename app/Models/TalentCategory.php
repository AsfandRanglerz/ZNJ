<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentCategory extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function entertainerDetail(){
        return $this->hasMany('App\Models\EntertainerDetail','category');
     }
}
