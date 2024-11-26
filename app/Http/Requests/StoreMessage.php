<?php

namespace App\Http\Requests;

class StoreMessage extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return [
            //
            'id_chatroom'      => 'required|string|exists:chatrooms,id',
            'id_user' => 'nullable|string|exists:users,id',
            'id_attachmemt' => 'nullable|string|exists:attachmemts,id',
            'message' => 'nullable|string',
            'type_message' => 'required|string|in:file,text,link',
            'name_file' => 'nullable|string',
            'type_file' =>  'nullable|string'
        ];
    }
}
