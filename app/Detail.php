<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable=['name','email','phone_number','address','zipcode'];
    //
    public function medias(){
        return $this->hasMany('App\Media');
    }

}
