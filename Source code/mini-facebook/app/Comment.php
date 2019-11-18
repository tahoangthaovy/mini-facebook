<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
//    const CREATED_AT = 'creation_date';
//    const UPDATED_AT = 'last_update';

    protected $table = "comments";

    protected $fillable = [
          'comment_content', 'post_id', 'user_id', 'image_path', 'is_new'
    ];
}
