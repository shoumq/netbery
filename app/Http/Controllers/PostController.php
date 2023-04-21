<?php

namespace App\Http\Controllers;

use App\Events\StoreLikeEvent;
use App\Events\StorePostEvent;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Li;

class PostController extends Controller
{
    public function store(User $user, PostRequest $request)
    {
        $post = new Post;
        $post->user_id = $user->id;
        $post->body = $request->body;
        $post->save();

        event(new StorePostEvent($post));

        return PostResource::make($post)->resolve();
    }

    public function postLike(Post $post)
    {
        $like = new Like;
        $like->from_id = Auth::user()->id;
        $like->post_id = $post->id;
        $like->like = '1';
        $like->save();

        event(new StoreLikeEvent($like));

        return $like;
    }
}
