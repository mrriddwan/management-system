<?php

namespace App\Traits\File;

use Illuminate\Http\Request;


trait FileTrait 
{
    public function uploadFile(Request $request) {
        $file = $request->file('logo');
        $path = $request->file('logo')->store('images');
     }
}