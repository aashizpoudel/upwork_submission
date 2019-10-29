<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
use Storage;

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

    public function uploadFiles(Request $request){
        $this->validate($request,[
            'file'=>"file|mimes:jpeg,bmp,png,pdf,docx,doc|required"
        ]);
        
        $data = [
            'name'=>strip_tags($request->file->getClientOriginalName()),
            'user_id'=>0, //Auth::user()->id
            'detail_id'=>0,
            'type'=>'file'
        ];
        $data['location'] = $request->file->store('uploads/files');

        $media = Media::create($data);
        return $media;
    }

    public function getImages(){
        return Media::images()->where('detail_id',0)->get();
    }

    public function getFiles(){
        return Media::files()->where('detail_id',0)->get();
    }

    public function delete($id){
        $media = Media::whereId($id)->where('detail_id',0)->first();
        if($media){
            Storage::delete($media->location);
            $media->delete();
            return response()->json("successfully deleted");
        }
        abort(411,'Unauthorized Action');
    }
}
