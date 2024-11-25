<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Traits\ApiResponseTrait;

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

    
}
