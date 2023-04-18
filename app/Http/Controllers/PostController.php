<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(User $user, PostRequest $request) {
        $post = New Post;
        $post->user_id = $user->id;
        $post->body = $request->body;
        $post->save();
    }
}
