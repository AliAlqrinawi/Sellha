<?php

namespace App\Http\Controllers\API\V1\Chat;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\ChatStoreRequest;
use App\Http\Resources\ChatCollection;
use App\Models\Chat;
use Illuminate\Http\Request;
use Throwable;

class ChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $chats = Chat::
        when($request->type, function($q) use ($request) {
            $q->where('type', $request->type);
        })
        ->when($request->status, function($q) use ($request) {
            $q->where('status', $request->status);
        })
        ->with('buyer' , 'seller' , 'product')->get();
        return (new ChatCollection($chats))->additional(['code' => 200 , 'status' => true, 'message' => Messages::getMessage('operation accomplished successfully')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChatStoreRequest $chatStoreRequest)
    {
        try {
            Chat::create($chatStoreRequest->userData());
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
        $chat = Chat::with('buyer' , 'seller' , 'product')->find($id);
        return parent::success($chat , Messages::getMessage('operation accomplished successfully'));
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
        try {
            Chat::find($id)->update($request->all());
            return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS', 200);
        } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chat::find($id)->delete();
        return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS', 200);
    }
}
