<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;

class UploadController extends Controller
{

    function getfiles()
    {
        return Storage::files('uploads');
    }


    function previewfile(Request $request)
    {
        return Storage::get($request->fichero);
    }


    function uploadfile(Request $request)
    {
        if($request->hasFile('file')) {
           $path = Storage::putFileAs('uploads', $request->file('file'), str_replace(' ', '_', $request->file('file')->getClientOriginalName()));
       }
    }



    function removefiles(Request $request) {
        foreach ($request->ficheros as $file) {
            Storage::delete($file);
        }
    }


}
