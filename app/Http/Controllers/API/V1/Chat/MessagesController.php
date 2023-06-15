<?php

namespace App\Http\Controllers\API\V1\Chat;

use App\Events\SendMessage;
use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Resources\MessageCollection;
use App\Models\Message;
use Illuminate\Http\Request;
use Throwable;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = Message::where('chat_id' , $request->chat_id)->orderBy('id', 'desc')->with('chat');
        $messages->whereIn('id' , $messages->pluck('id')->toArray())->update([
            'is_read' => 1,
        ]);
        return (new MessageCollection($messages->get()))->additional(['code' => 200 , 'status' => true, 'message' => Messages::getMessage('operation accomplished successfully')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageStoreRequest $messageStoreRequestst)
    {
        try {
            $message = Message::create($messageStoreRequestst->messageData());
            event(new SendMessage($message));
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
