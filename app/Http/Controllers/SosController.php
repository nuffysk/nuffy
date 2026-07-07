<?php

namespace App\Http\Controllers;

use App\Models\SosReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SosController extends Controller
{
    public function index(Request $request): View
    {
        $kind = in_array($request->query('kind'), ['found', 'lost']) ? $request->query('kind') : 'found';
        $city = $request->query('city');

        $query = SosReport::with('reporter:id,name,display_name,avatar_url')
            ->where('kind', $kind)
            ->where('status', '!=', 'resolved')
            ->orderByDesc('created_at');

        if ($city) $query->where('city', $city);

        $reports = $query->limit(50)->get();
        $cities = SosReport::where('kind', $kind)->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

        return view('sos.index', compact('reports', 'kind', 'city', 'cities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kind' => ['required', 'in:found,lost'],
            'dog_name' => ['nullable', 'string', 'max:40'],
            'description' => ['required', 'string', 'min:5', 'max:1000'],
            'city' => ['nullable', 'string', 'max:60'],
            'phone' => ['nullable', 'string', 'max:30'],
            'phone_consent' => ['nullable', 'boolean'],
            'instagram' => ['nullable', 'string', 'max:60'],
            'contact' => ['nullable', 'string', 'max:120'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ], [
            'description.required' => 'Vyplň prosím popis.',
            'description.min' => 'Popis musí mať aspoň 5 znakov.',
            'photo.max' => 'Fotka môže mať najviac 5 MB.',
            'photo.image' => 'Súbor musí byť obrázok (JPG, PNG).',
        ]);

        if (! empty(trim($data['phone'] ?? '')) && empty($data['phone_consent'])) {
            return back()->withInput()->with('status', 'Pre zverejnenie telefónneho čísla musíš odsúhlasiť podmienky.');
        }
        unset($data['phone_consent']);

        $nameTrim = trim($data['dog_name'] ?? '');
        $finalName = $nameTrim !== '' ? $nameTrim : ($data['kind'] === 'found' ? 'nepoznáme' : '');
        if ($finalName !== '') {
            $data['description'] = "Meno: {$finalName}\n\n".$data['description'];
        }
        unset($data['dog_name']);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('sos-photos/'.Auth::id(), 'public');
            $data['photo_url'] = Storage::url($path);
        }

        unset($data['photo']);
        SosReport::create(array_merge($data, [
            'reporter_id' => Auth::id(),
            'status' => 'open',
        ]));

        return back()->with('status', 'Hlásenie odoslané. Ďakujeme ♥');
    }

    public function help(): View
    {
        return view('sos.help');
    }
}
