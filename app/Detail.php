<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    //
    public function medias(){
        return $this->hasMany('App\Media');
    }

}
