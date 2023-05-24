<?php

namespace App\Http\Controllers;

use App\Models\Icons;
use App\Models\UserIcons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    public function renderPage()
    {
        $allIcons = Icons::all();
        $myIcons = UserIcons::where('user_id', Auth::user()->id)->get();
        return inertia('Market', compact('allIcons', 'myIcons'));
    }
}
