<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $users = collect();
        $places = collect();

        if (strlen($q) >= 2) {
            $users = User::where('display_name', 'like', "%{$q}%")
                ->orWhere('name', 'like', "%{$q}%")
                ->limit(20)
                ->get(['id', 'name', 'display_name', 'city', 'avatar_url']);
            $places = Place::where('name', 'like', "%{$q}%")
                ->limit(20)
                ->get(['id', 'name', 'city', 'category']);
        }

        return view('search.index', compact('q', 'users', 'places'));
    }
}
