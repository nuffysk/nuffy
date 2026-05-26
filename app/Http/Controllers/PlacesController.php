<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceSuggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PlacesController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category', 'hotel');
        $city = $request->query('city');

        $query = Place::query();
        if (in_array($category, ['gastro', 'park', 'kennel', 'daycare', 'grooming', 'hotel'])) {
            $query->where('category', $category);
        }
        if ($city) {
            $query->where('city', $city);
        }
        $places = $query->orderBy('city')->orderBy('name')->get();

        $cities = Place::where('category', $category)->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

        return view('places.index', compact('places', 'cities', 'category', 'city'));
    }

    public function show(Place $place): View
    {
        return view('places.show', compact('place'));
    }

    public function suggest(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category' => ['required', 'in:gastro,park,kennel,daycare,grooming,hotel'],
            'name' => ['required', 'string', 'max:200'],
            'note' => ['nullable', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:60'],
        ]);
        PlaceSuggestion::create(array_merge($data, ['user_id' => Auth::id()]));
        return back()->with('status', 'Ďakujeme za tip! 🐾');
    }
}
