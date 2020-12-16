<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadSingleImage(){

        if(request()->hasFile('file')){

            $file = request()->file('file');
            $filename = $file->getClientOriginalName().'-'.time().'.'.$file->getClientOriginalExtension();
            $destination = 'images/dropzone';

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move(public_path($destination), $filename);
            $path = $destination.'/'.$filename;

            return response()->json(['status' => true, 'path' => $path]);

        }

        return response()->json(['status' => false]);
    }


    public function uploadSummernoteImage() {
        $this->validate(request(),[
            'file' => 'image|mimes:jpg,jpeg,png'
        ]);
        if(request()->hasFile('file')){

            $file = request()->file('file');
            $filename = $file->getClientOriginalName().'-'.time().'.'.$file->getClientOriginalExtension();
            $destination = 'images/summernote';

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move(public_path($destination), $filename);
            $path = '/'.$destination.'/'.$filename;

            return response()->json(['status' => true, 'path' => $path]);
        }

        return response()->json(['status' => false]);
    }
}
