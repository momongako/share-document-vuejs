<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = ['post_id', 'content', 'user_id', 'user_name','user_image'];

}
