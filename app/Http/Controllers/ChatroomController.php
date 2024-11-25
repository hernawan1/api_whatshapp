<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatroom;
use App\Http\Requests\StoreChatroom;
use App\Traits\ApiResponseTrait;

class ChatroomController extends Controller
{
    use ApiResponseTrait;
    //
    public function index(Request $request){
        $user    = $request->user();
        $limit   = $request->get('limit', 10);


        $data = Chatroom::query()
            ->whereHas('memberChatroom', function($query){
                $query->where('id_user', $user->id);
            })
            ->paginate($limit)
            ->appends([
                'limit' => $limit,
            ]);

        return $this->successResponse($data);
    }

    public function store(StoreChatroom $request, Chatroom $chatroom){
        $validatedData = $request->validated();
        $chatroom = Chatroom::create($validatedData);
        return $this->successResponse($chatroom);
    }

    public function show(Chatroom $chatroom){
        $chatroom = $chatroom->load([
            'memberChatroom',
            'message.user',
            'message.attachmemt'
        ]);
        return $this->successResponse($chatroom);
    }
}
