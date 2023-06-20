<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\DesireStoreRequest;
use App\Models\Desire;

class DesiresController extends Controller
{
    public function store(DesireStoreRequest $desireStoreRequest)
    {
        Desire::create($desireStoreRequest->desireData());
        return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS', 200);
    }

    public function destroy($id)
    {
        Desire::find($id)->delete();
        return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS', 200);
    }

}
