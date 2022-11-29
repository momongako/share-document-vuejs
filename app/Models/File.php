<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends BaseModel
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = ['name', 'path', 'post_id', 'type','size'];

    protected $hidden = [];
}
