<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityPostRequest;
use App\Http\Resources\Community\CommunityResource;
use App\Http\Resources\Community\MyCommunityResource;
use App\Http\Resources\Community\PostCommunityResource;
use App\Http\Resources\Community\UsersCommunityResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Community;
use App\Models\Community_image;
use App\Models\Community_like;
use App\Models\Community_post;
use App\Models\Community_subscriber;
use App\Models\Image_users;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;
use Orhanerday\OpenAi\OpenAi;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::all();
        return inertia('Community/Community', compact('communities'));
    }

    public function myCommunity(User $user)
    {
        $communities = Community_subscriber::where('user_id', $user->id)->get();
        $communities = MyCommunityResource::collection($communities)->resolve();
        return inertia('Community/MyCommunity', compact('communities', 'user'));
    }

    public function create()
    {
        return inertia('Community/Create');
    }

    public function store(Request $request)
    {
        $community = new Community;
        $community->title = $request->title;
        $community->status = $request->status;
        $community->isVerified = '0';
        $community->admin = Auth::user()->id;
        $community->save();

        $community_sub = new Community_subscriber;
        $community_sub->user_id = Auth::user()->id;
        $community_sub->community_id = $community->id;
        $community_sub->save();

        return $community;
    }

    public function getCommunity(Community $community)
    {
        $posts = Community_post::where('community_id', $community->id)->latest()->get();
        $posts = PostCommunityResource::collection($posts)->resolve();

        $communities_sub = Community_subscriber::where('community_id', $community->id)->get();
        $communities_sub = UsersCommunityResource::collection($communities_sub)->resolve();

        $isSub = count(Community_subscriber::where('user_id', Auth::user()->id)
            ->where('community_id', $community->id)->get());

        $admin = User::find($community->admin);

        return inertia('Community/Profile', compact('community', 'posts', 'communities_sub', 'isSub', 'admin'));
    }

    public function storePost(Community $community, CommunityPostRequest $request)
    {
        $community_post = new Community_post;
        $community_post->body = $request->body;
        $community_post->community_id = $community->id;
        $community_post->save();

//        return $community_post;
        return PostResource::make($community_post)->resolve();
    }

    public function deletePost(Community_post $post)
    {
        $del_p = Community_post::find($post->id);
        $del_p->delete();
    }

    public function postLike(Post $post)
    {
        if (count(Community_like::where('post_id', $post->id)
                ->where('from_id', Auth::user()->id)->get()) == 0) {
            $like = new Community_like();
            $like->from_id = Auth::user()->id;
            $like->post_id = $post->id;
            $like->like = '1';
            $like->save();

            $count_global = Community_like::where('post_id', $post->id)->get();

            return response()->json([
                "likes" => count($count_global),
                "my_like" => count(Community_like::where('post_id', $post->id)
                    ->where('from_id', Auth::user()->id)->get()),
                "like_id" => Community_like::where('post_id', $post->id)
                    ->where('from_id', Auth::user()->id)->first()
            ]);
        } else {
            $count_mine = Community_like::where('post_id', $post->id)
                ->where('from_id', Auth::user()->id)->first();
            $like = Community_like::find($count_mine->id);
            $like->delete();

            $count_global = Community_like::where('post_id', $post->id)->get();

            return response()->json([
                "likes" => count($count_global),
                "my_like" => count(Community_like::where('post_id', $post->id)
                    ->where('from_id', Auth::user()->id)->get())
            ]);
        }
    }

    public function subscribe(Community $community)
    {
        if (count(Community_subscriber::where('user_id', Auth::user()->id)
                ->where('community_id', $community->id)->get()) == 0) {
            $community_sub = new Community_subscriber;
            $community_sub->user_id = Auth::user()->id;
            $community_sub->community_id = $community->id;
            $community_sub->save();

            return $community_sub;
        }
    }

    public function unsubscribe(Community $community)
    {
        $community_sub = Community_subscriber::where('user_id', Auth::user()->id)
            ->where('community_id', $community->id)->first();
        $community_sub->delete();

        return $community_sub;
    }

    public function updateStatus(Community $community, Request $request)
    {
        $community = Community::find($community->id);
        $community->status = $request->status;
        $community->save();

        return $community;
    }

    public function updateImage(Request $request)
    {
        $name = $request->file('file')->getClientOriginalName();
        $size = $request->file('file')->getSize();

        $request->file('file')->storeAs('public/images/', $name);

        $photo = new Community_image();
        $photo->name = $name;
        $photo->size = $size;
        $photo->community_id = $request->community_id;
        $photo->save();

        $community = Community::find($request->community_id);
        $community->img_id = $name;
        $community->save();

        return $community;
    }


//    public function chatGPT()
//    {
//        $open_ai_key = "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";
//        $open_ai = new OpenAi($open_ai_key);
//        $open_ai->setORG("org-i1EaYCZUoqt2PvO9C5VpgOLs");
//
//        $complete = $open_ai->completion([
//            'model' => 'text-davinci-002',
//            'prompt' => 'Hello',
//            'temperature' => 0.9,
//            'max_tokens' => 150,
//            'frequency_penalty' => 0,
//            'presence_penalty' => 0.6,
//        ]);
//
//        return json_decode($complete, true);
//    }
}
