<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        $categoryId = request()->categoryId ?? '';
        $pinPost =  request()->is_pin ?? '';
        $category = Category::find($categoryId);
        $user = auth()->user();

        if ($user->is_admin == User::NOT_ADMIN && (!in_array($category->slug, [KNOWLEDGE_SHARING, GALLERY]) || $pinPost == Post::PIN)) {
            return false;
        }

        return true;
    }

    public function update(User $user, Post $post)
    {
        $categoryId = request()->categoryId ?? '';
        $pinPost =  request()->is_pin ?? '';
        $category = Category::find($categoryId);
        $user = auth()->user();

        if (($user->id === $post->user_id && (in_array($category->slug, [KNOWLEDGE_SHARING, GALLERY]) || $pinPost == Post::NOT_PIN)) || $user->is_admin === ADMIN) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Post $post)
    {
        if ($user->id === $post->user_id || $user->is_admin === ADMIN) {
            return true;
        }

        return false;
    }
}
