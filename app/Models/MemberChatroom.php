<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class MemberChatroom extends Model
{
    //
    use HasFactory;
    use HasSnowflakePrimary;
    use SoftDeletes;
    //
    protected $table      = 'member_chatrooms';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id'                    => 'string',
        'id_chatroom'           => 'string',
        'id_user'               => 'string',
    ];
    protected $fillable = [
        'id_chatroom',
        'id_user',
        'status_member'
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
}
