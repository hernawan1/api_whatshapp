<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class Message extends Model
{
    //
    use HasFactory;
    use HasSnowflakePrimary;
    use SoftDeletes;
    //
    protected $table      = 'messages';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id'                    => 'string',
        'id_chatroom'           => 'string',
        'id_user'               => 'string',
        'id_attachmemt'         => 'string'
    ];
    protected $fillable = [
        'id_chatroom',
        'id_user',
        'id_attachmemt',
        'message',
        'type_message'
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function chatroom(){
        return $this->belongsTo(Chatroom::class, 'id_chatroom', 'id');
    }

    public function attachmemt(){
        return $this->belongsTo(Attachmemt::class, 'id_attachmemt', 'id');
    }
}
