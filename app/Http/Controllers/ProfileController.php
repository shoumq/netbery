<?php

namespace App\Http\Controllers;

use App\Events\OnlineEvent;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\Community\CommunityResource;
use App\Http\Resources\Dialog\DialogResource;
use App\Http\Resources\Images\ImagesResource;
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
use App\Models\UserIcons;
use Carbon\Carbon;
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
        $user = User::where('login', $user_login)->first();

        $posts = Post::where('user_id', $user->id)->latest()->get();
        $posts = PostResource::collection($posts)->resolve();

        $friends = Dialog::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)->inRandomOrder()->limit(3)->get();
        $friends = DialogResource::collection($friends)->resolve();

        $communities = Community_subscriber::where('user_id', $user->id)->inRandomOrder()->limit(3)->get();
        $communities = CommunityResource::collection($communities)->resolve();

        $dialogs = Dialog::where('user_one', Auth::user()->id)
            ->orWhere('user_two', Auth::user()->id)->orderBy('updated_at', 'DESC')->get();
        $dialogs = DialogResource::collection($dialogs)->resolve();

        $images = Image_users::where('user_id', $user->id)->get();
        $images = ImagesResource::collection($images)->resolve();

        return inertia('Profile', compact('user', 'posts', 'friends', 'communities', 'dialogs', 'images'));
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

        $dialogs = Dialog::where('user_one', Auth::user()->id)
            ->orWhere('user_two', Auth::user()->id)->orderBy('updated_at', 'DESC')->get();
        $dialogs = DialogResource::collection($dialogs)->resolve();

        $result = array();
        for ($i = 0; $i < count($posts); $i++) {
            if (count($posts[$i]['posts']) > 0) {
                array_push($result, $posts[$i]);
            }
        }

        return inertia('News', compact('posts', 'result', 'dialogs'));
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

        return $photo;
    }

    public function test()
    {
        return inertia('test');
    }

    public function pagePhotos(User $user)
    {
        $images = Image_users::where('user_id', $user->id)->get();
        $images = ImagesResource::collection($images)->resolve();
        return inertia('Images', compact('images', 'user'));
    }

    public function addImage(Request $request)
    {
        $name = $request->file('file')->getClientOriginalName();
        $size = $request->file('file')->getSize();

        $request->file('file')->storeAs('public/images/', $name);

        $photo = new Image_users();
        $photo->name = $name;
        $photo->size = $size;
        $photo->user_id = Auth::user()->id;
        $photo->save();

//        return response()->json([
//            "filename" => $name
//        ]);
        return $photo;
    }

    public function delImage($id)
    {
        Image_users::destroy($id);
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

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            "response" => "email success"
        ]);
    }

    public function setPassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->fill(['password' => Hash::make($request->password)])->save();

        return response()->json([
            "response" => "password success"
        ]);
    }

    public function setPrivate(Request $request) {
        $req_show_email = $request->show_email;
        $user = User::find(Auth::user()->id);
        $user->show_email = $req_show_email;
        $user->save();
    }

    public function updateOnline()
    {
        $user = User::find(Auth::user()->id);

        $totalDuration = Carbon::now()->diffInSeconds($user->updated_at);

        $user->updated_at = Carbon::now();
        $user->save();


        return response()->json([
            "user" => $user->updated_at,
            "now" => Carbon::now(),
            "result" => gmdate('H:i:s', $totalDuration)
        ]);
    }

    public function getOnline(User $user)
    {
        Carbon::setLocale('ru');

        $user = User::find($user->id);

        $totalDuration = Carbon::now()->diffInSeconds($user->updated_at);

        return response()->json([
            "result" => gmdate('H:i:s', $totalDuration),
            "time" => $user->updated_at->diffForHumans()
        ]);
    }

    public function chooseIcon(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->admin = $request->iconId;
        $user->save();
    }

    public function addIcon(Request $request) {
        $count = count(UserIcons::where('user_id', Auth::user()->id)
            ->where('icon_id', $request->iconId)->get());

        if ($count == 0) {
            $user_icon = new UserIcons();
            $user_icon->user_id = Auth::user()->id;
            $user_icon->icon_id = $request->iconId;
            $user_icon->save();

            return $user_icon;
        } else {
            return "err";
        }
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
