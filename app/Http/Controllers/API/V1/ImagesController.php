<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class ImagesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $files = File::whereIn('id', $request->ids);
        foreach ($files->get() as $file) {
            FacadesFile::delete($file->file);
        }
        $files->delete();
        return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS', 200);
    }
}
