<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'message' => 'required|string',
            'type_message' => 'required|string|in:file,text,link',
        ];
    }
}
