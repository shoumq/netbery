<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\Community\CommunityResource;
use App\Http\Resources\Dialog\DialogResource;
use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\News\NewsResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Community;
use App\Models\Community_subscriber;
use App\Models\Dialog;
use App\Models\Image_users;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\Console\Input\Input;

class ProfileController extends Controller
{
    public function index($user_login)
    {
        $user = User::where('login', $user_login)->get()[0];

        $posts = Post::where('user_id', $user->id)->latest()->get();
        $posts = PostResource::collection($posts)->resolve();

        $friends = Dialog::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)->inRandomOrder()->limit(3)->get();
        $friends = DialogResource::collection($friends)->resolve();

        $communities = Community_subscriber::where('user_id', $user->id)->inRandomOrder()->limit(3)->get();
        $communities = CommunityResource::collection($communities)->resolve();

        return inertia('Profile', compact('user', 'posts', 'friends', 'communities'));
    }

    public function updateStatus(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->status = $request->status;
        $user->save();

        return $user;
    }

    public function news()
    {
        $posts = Community_subscriber::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->get();
        $posts = NewsResource::collection($posts)->resolve();

        $result = array();
        for ($i = 0; $i < count($posts); $i++) {
            if (count($posts[$i]['posts']) > 0) {
                array_push($result, $posts[$i]);
            }
        }

        return inertia('News', compact('posts', 'result'));
    }

    public function updateImage(Request $request)
    {
        $name = $request->file('file')->getClientOriginalName();
        $size = $request->file('file')->getSize();

        $request->file('file')->storeAs('public/images/', $name);

        $photo = new Image_users();
        $photo->name = $name;
        $photo->size = $size;
        $photo->user_id = Auth::user()->id;
        $photo->save();

        $user = User::find(Auth::user()->id);
        $user->img_id = $name;
        $user->save();

        return $user;
    }

    public function test()
    {
        return inertia('test');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => Auth::user()
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

    public function setName(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->save();

        return response()->json([
            "response" => "name success"
        ]);
    }

    public function setSurname(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->surname = $request->surname;
        $user->save();

        return response()->json([
            "response" => "surname success"
        ]);
    }

    public function setEmail(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->email = $request->email;
        $user->save();

        return response()->json([
            "response" => "email success"
        ]);
    }

    public function setPassword(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->fill(['password' => Hash::make($request->password)])->save();

        return response()->json([
            "response" => "password success"
        ]);
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
