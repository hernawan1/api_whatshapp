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
            dd($validatedData);
            if($validatedData['type_message'] == 'file'){
                $attchmemt = Attachmemt::create($validatedData);

                $validatedData['message'] = $attchmemt->path;
                $validatedData['id_attachmemt'] = $attchmemt->id;

                $createMessage = $message->create($validatedData);

                event(new MessageSent($message));
                return $this->successResponse($createMessage);
            }
            $createMessage = $message->create($validatedData);

            event(new MessageSent($message));
            return $this->successResponse($createMessage);
        }catch (Exception $e) {
            return $this->internalErrorResponse($e->getMessage());
        }

    }
}
