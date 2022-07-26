<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Image;

class FileController extends Controller
{
    public function store(Request $request) {
        $file = new Image();
        $image = $request->file('file')->store('apiFiles');
        $file->name = $image;

        $file->save();
        return $image;
    }
}
