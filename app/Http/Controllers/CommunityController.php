<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityPostRequest;
use App\Http\Resources\Community\CommunityResource;
use App\Models\Community;
use App\Models\Community_post;
use App\Models\Community_subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::all();
        return inertia('Community/Community', compact('communities'));
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
        $community->image = '';
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

        $communities_sub = Community_subscriber::where('community_id', $community->id)->get();
        $communities_sub = CommunityResource::collection($communities_sub)->resolve();

        $isSub = count(Community_subscriber::where('user_id', Auth::user()->id)
            ->where('community_id', $community->id)->get());

        return inertia('Community/Profile', compact('community', 'posts', 'communities_sub', 'isSub'));
    }

    public function storePost(Community $community, CommunityPostRequest $request)
    {
        $community_post = new Community_post;
        $community_post->body = $request->body;
        $community_post->community_id = $community->id;
        $community_post->save();

        return $community_post;
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

    public function unsubscribe(Community $community) {
        $community_sub = Community_subscriber::where('user_id', Auth::user()->id)
            ->where('community_id', $community->id)->first();
        $community_sub->delete();

        return $community_sub;
    }
}
