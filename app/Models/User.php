<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // Role user
    const ADMIN = 1;
    const NOT_ADMIN = 2;

    protected $fillable = [
        'name',
        'email',
        'image',
        'is_admin',
        'password',
        'user_company',
        'user_department',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function likes(){
        return $this->belongsToMany( Post::class, 'users_like_posts', 'user_id', 'post_id');
    }
}
