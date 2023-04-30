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
use function Pest\Laravel\get;
use function Pest\Laravel\json;

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
        if (count(Like::where('post_id', $post->id)
                ->where('from_id', Auth::user()->id)->get()) == 0) {
            $like = new Like;
            $like->from_id = Auth::user()->id;
            $like->post_id = $post->id;
            $like->like = '1';
            $like->save();

            $count_global = Like::where('post_id', $post->id)->get();

            return response()->json([
                "likes" => count($count_global),
                "my_like" => count(Like::where('post_id', $post->id)
                    ->where('from_id', Auth::user()->id)->get()),
                "like_id" => Like::where('post_id', $post->id)
                    ->where('from_id', Auth::user()->id)->first()
            ]);
        } else {
            $count_mine = Like::where('post_id', $post->id)
                ->where('from_id', Auth::user()->id)->first();
            $like = Like::find($count_mine->id);
            $like->delete();

            $count_global = Like::where('post_id', $post->id)->get();

            return response()->json([
                "likes" => count($count_global),
            ]);
        }

    }

    public function postLike2(Post $post)
    {
        $like = new Like;
        $like->from_id = Auth::user()->id;
        $like->post_id = $post->id;
        $like->like = '1';
        $like->save();

        $count_global = Like::where('post_id', $post->id)->get();

        return response()->json([
            "likes" => count($count_global),
            "my_like" => count(Like::where('post_id', $post->id)
                ->where('from_id', Auth::user()->id)->get()),
            "like_id" => Like::where('post_id', $post->id)
                ->where('from_id', Auth::user()->id)->first()
        ]);
    }

    public function deleteLike(Post $post)
    {
        $count_mine = Like::where('post_id', $post->id)
            ->where('from_id', Auth::user()->id)->first();
        $like = Like::find($count_mine->id);
        $like->delete();

        return response()->json([
            "del" => "success"
        ]);
    }

    public function checkLike(Post $post)
    {
        return (Like::where('post_id', $post->id)->get());
    }
}
