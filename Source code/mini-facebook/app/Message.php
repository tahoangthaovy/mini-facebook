<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
//    const CREATED_AT = 'creation_date';
//    const UPDATED_AT = 'last_update';

    protected $table = "messages";

    protected $fillable = [
        'message_content',
        'sent_user',
        'received_user',
        'group_id',
        'is_new',
        'created_at',
        'updated_at'
    ];
}
