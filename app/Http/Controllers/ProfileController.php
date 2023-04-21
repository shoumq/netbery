<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\Community\CommunityResource;
use App\Http\Resources\Dialog\DialogResource;
use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Community_subscriber;
use App\Models\Dialog;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index($user_login)
    {
        $user = User::where('login', $user_login)->get()[0];

        $posts = Post::where('user_id', $user->id)->latest()->get();
        $posts = PostResource::collection($posts)->resolve();

        $friends = Dialog::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)->get();
        $friends = DialogResource::collection($friends)->resolve();

        $communities = Community_subscriber::where('user_id', $user->id)->get();
        $communities = CommunityResource::collection($communities)->resolve();

        return inertia('Profile', compact('user', 'posts', 'friends', 'communities'));
    }

    public function updateStatus(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->status = $request->status;
        $user->save();

        return $user;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
