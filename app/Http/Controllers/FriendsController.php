<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function index() {
        return inertia('Friends');
    }

    public function allUsers() {
        $users = User::all();
        return inertia('AllUsers', compact('users'));
    }
}
