<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'id',
        'title',
        'category_id',
        'category_name',
        'content',
        'user_id',
        'user_name',
        'user_company',
        'has_attachment'

    ];

}
