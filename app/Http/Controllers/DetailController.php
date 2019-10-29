<?php

namespace App\Http\Controllers;

use App\Detail;
use Illuminate\Http\Request;
use App\Media;

class DetailController extends Controller
{
    //
    public function store(Request $request){
        $data = $this->validate($request,[
            'name'=>'string|required|min:3|max:30',
            'email'=>'email|required',
            'phone_number'=>'string|required|max:20',
            'address'=>'string|required|min:3|max:50',
            'zipcode'=>'string|required|size:5'
        ]);

        
        $media_files = Media::where('detail_id',0)->where('type','file')->get(); //get unassociated media
        $media_images = Media::where('detail_id',0)->where('type','image')->get();

        if($media_images->count()==0){
            return response()->json(['errors'=>['image'=>["No image included"] ]],422);
        }

        if($media_files->count()==0){
            return response()->json(['errors'=>['file'=>["No file included"] ]],422);
        }

       

        $detail = Detail::create($data);
        $detail->medias()->saveMany($media_images);
        $detail->medias()->saveMany($media_files);
        return $detail;

    }
}
