<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\DenouncementStore;
use App\Http\Resources\ReasonCollection;
use App\Models\Denouncement;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class DenouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reasons = Reason::get();
        return (new ReasonCollection($reasons));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DenouncementStore $denouncementStore)
    {
        $data = $denouncementStore->all();
        try {
            $data['user_id'] = Auth::user()->id;
            Denouncement::create($data);
            return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS', 200);
        } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
