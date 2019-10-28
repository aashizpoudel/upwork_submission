<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;

class MediaController extends Controller
{
    //
    public function uploadImages(Request $request){
        $this->validate($request,[
            'image'=>"image|required"
        ]);
        
        $data = [
            'name'=>strip_tags($request->image->getClientOriginalName()),
            'user_id'=>0, //Auth::user()->id
            'detail_id'=>0,
            'type'=>'image'
        ];
        $data['location'] = $request->image->store('uploads/images');

        $media = Media::create($data);
        return $media;
    }

    public function getImages(){
        return Media::images()->where('detail_id',0)->get();
    }
}
