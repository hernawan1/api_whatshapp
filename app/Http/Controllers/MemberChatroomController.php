<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberChatroom;
use App\Models\Chatroom;
use App\Http\Requests\UpdateMemberChatroom;
use App\Traits\ApiResponseTrait;

class MemberChatroomController extends Controller
{
    use ApiResponseTrait;
    //
    public function index(Request $request){
        $data =  MemberChatroom::with([
            'user'
        ])->where('id_chatroom', $request->id_chatroom)->get();

        return $this->successResponse($data);
    }

    public function store(Request $request, MemberChatroom $memberChatroom){
        $requestMember = $request->dataMember;
        $length = count($requestMember);
        if($length != 0){
            foreach($requestMember as $key => $value){
                $sumMember = $memberChatroom->where('id_chatroom',$value->id_chatroom)->get()->count();
                $chatRoom = Chatroom::where('id', $value->id_chatroom)->first();
                if($sumMember > $chatRoom->max_member){
                    $data = [
                        "message"   => "Maximum Member In Chatroom"
                    ];
                    return $this->badRequestResponse($data);
                }else{
                    $data = $memberChatroom->created([
                        'id_chatroom'   => $value->id_chatroom,
                        'id_user'       => $value->id_user,
                        'status_member' => 'join'
                    ]);
                    return $this->createdResponse($data);
                }
            }
        }else{
            $data = [
                "message"   => "Member Length 0"
            ];
            return $this->badRequestResponse($data);
        }
    }

    public function update(UpdateMemberChatroom $request, MemberChatroom $memberChatroom){
        $validatedData = $request->validated();
        $memberChatroom->update($validatedData);
        return $this->successResponse($memberChatroom);
    }
}
