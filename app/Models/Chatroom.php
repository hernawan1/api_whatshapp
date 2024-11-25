<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class Chatroom extends Model
{
    //
    use HasFactory;
    use HasSnowflakePrimary;
    use SoftDeletes;
    //
    protected $table      = 'chatrooms';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id'                    => 'string',
    ];
    protected $fillable = [
        'name_chatrooms',
        'max_member'
    ];
    protected $hidden = [
        'deleted_at',
    ];
}
