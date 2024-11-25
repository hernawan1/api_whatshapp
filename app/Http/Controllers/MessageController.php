<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Attachmemt;
use App\Traits\ApiResponseTrait;
use Exception;
use App\Events\MessageSent;
use App\Http\Requests\StoreMessage;

class MessageController extends Controller
{
    use ApiResponseTrait;
    //
    public function index(Request $request){
        $data =  Message::with([
            'user',
            'attachmemt'
        ])->where('id_chatroom', $request->id_chatroom)->get();

        return $this->successResponse($data);
    }

    public function store(StoreMessage $request, Message $message){
        try{
            $validatedData = $request->validated();
            if($validatedData['type_message'] == 'file'){
                $attchmemt = Attachmemt::create($validatedData);
                $validatedData->message = $attchmemt->path;
                $createMessage = $message->create($validatedData);
                event(new MessageSent($createMessage->id_chatroom, $createMessage->id_user, $createMessage->message));
                return $this->successResponse($reateMessage);
            }
            $createMessage = $message->create($validatedData);
            event(new MessageSent($createMessage->id_chatroom, $createMessage->id_user, $createMessage->message));
            return $this->successResponse($reateMessage);
        }catch (Exception $e) {
            return $this->internalErrorResponse($e->getMessage());
        }

    }
}
