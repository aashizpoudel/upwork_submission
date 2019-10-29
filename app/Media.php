<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable=['name','location','user_id','detail_id','type'];
    protected $table = 'medias';
    //
    public function scopeFiles($query){
        return $query->whereType('file');
    }

    public function scopeImages($query){
        return $query->whereType('image');
    }
}
