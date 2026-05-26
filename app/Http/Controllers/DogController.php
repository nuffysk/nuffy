<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DogController extends Controller
{
    public function edit(): View
    {
        $dog = Auth::user()->dogs()->first() ?? new Dog(['gender' => 'unspecified', 'vaccinated' => false]);
        return view('dog.edit', compact('dog'));
    }

    public function save(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $dog = $user->dogs()->first();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:40'],
            'breed' => ['nullable', 'string', 'max:60'],
            'birth_date' => ['nullable', 'date', 'before:tomorrow'],
            'personality' => ['nullable', 'string', 'max:300'],
            'size' => ['nullable', 'in:small,medium,large'],
            'gender' => ['required', 'in:male,female,unspecified'],
            'health_notes' => ['nullable', 'string', 'max:500'],
            'vaccinated' => ['nullable', 'boolean'],
            'neutered' => ['nullable', 'boolean'],
            'microchipped' => ['nullable', 'boolean'],
            'vaccinations' => ['nullable', 'array'],
            'vaccinations.*' => ['string', 'max:50'],
            'vet' => ['nullable', 'string', 'max:120'],
            'photos' => ['nullable', 'array', 'max:4'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        $data['vaccinated'] = $request->boolean('vaccinated');
        $data['neutered'] = $request->boolean('neutered');
        $data['microchipped'] = $request->boolean('microchipped');
        $data['vaccinations'] = $data['vaccinated'] ? ($data['vaccinations'] ?? []) : [];

        $photoPaths = $dog?->photos ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('dog-photos/'.$user->id, 'public');
                $photoPaths[] = Storage::url($path);
                if (count($photoPaths) >= 4) break;
            }
        }
        $data['photos'] = array_values(array_slice($photoPaths, 0, 4));
        $data['photo_url'] = $data['photos'][0] ?? null;

        unset($data['vaccinations']);
        $data['vaccinations'] = $request->boolean('vaccinated') ? array_values($request->input('vaccinations', [])) : [];

        if ($dog) {
            $dog->update($data);
        } else {
            $data['owner_id'] = $user->id;
            $dog = Dog::create($data);
        }

        return redirect()->route('dog.edit')->with('status', 'Profil psíka uložený.');
    }

    public function destroy(): RedirectResponse
    {
        Auth::user()->dogs()->delete();
        return redirect()->route('dog.edit')->with('status', 'Psík odstránený.');
    }
}
