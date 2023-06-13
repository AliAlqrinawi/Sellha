<?php

namespace App\Http\Controllers\API\V1\Chat;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\ChatStoreRequest;
use App\Http\Resources\ChatCollection;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $chats = Chat::where('sender_id' , Auth::user()->id)
        ->orwhere('receiver_id' , Auth::user()->id)
        ->when($request->status, function($q) use ($request) {
            $q->where('status', $request->status);
        })
        ->with('sender' , 'receiver' , 'product' , 'lastMessage')->get();
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
            $oldChat = Chat::where('sender_id' , $chatStoreRequest->sender_id)
            ->where('receiver_id' , $chatStoreRequest->receiver_id)
            ->where('product_id' , $chatStoreRequest->product_id)
            ->with('sender' , 'receiver' , 'product' , 'lastMessage')->first();
            if($oldChat){
                return parent::success($oldChat , Messages::getMessage('operation accomplished successfully'));
            }
            $newChat = Chat::create($chatStoreRequest->userData());
            $Chat = Chat::with('sender' , 'receiver' , 'product' , 'lastMessage')->find($newChat->id);
            return parent::success($Chat , Messages::getMessage('operation accomplished successfully'));
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
        $chat = Chat::with('sender' , 'receiver' , 'product' , 'lastMessage')->find($id);
        return parent::success($chat , Messages::getMessage('operation accomplished successfully'));
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
