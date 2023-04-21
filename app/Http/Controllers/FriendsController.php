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

    public function search(Request $request) {
        $result = User::where('name', 'LIKE', '%' . $request->searchInput . '%')
            ->orWhere('surname', 'LIKE', '%' . $request->searchInput . '%')
            ->orWhere('login', 'LIKE', '%' . $request->searchInput . '%')
            ->orWhere('email', 'LIKE', '%' . $request->searchInput . '%')
            ->get();

        return $result;
    }
}
