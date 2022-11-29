<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referrence extends Model
{
    use HasFactory;

    protected $table = 'referrences';

    protected $fillable = [
        'id',
        'post_id',
        'post_id_referrence',
        'post_name_referrence'
    ];
}

