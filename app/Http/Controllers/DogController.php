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
    /**
     * Form for creating a new dog.
     */
    public function create(): View
    {
        $dog = new Dog(['gender' => 'unspecified', 'vaccinated' => false]);

        return view('dog.edit', compact('dog'));
    }

    /**
     * Form for editing an existing dog owned by the current user.
     */
    public function edit(Dog $dog): View
    {
        $this->authorizeOwner($dog);

        return view('dog.edit', compact('dog'));
    }

    /**
     * Create a new dog for the current user.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $user = Auth::user();

        $data = $this->applyPhotos($request, $data, null, $user->id);
        $data['owner_id'] = $user->id;

        Dog::create($data);

        return redirect()->route('profile.show')->with('status', 'Profil psíka vytvorený.');
    }

    /**
     * Update an existing dog.
     */
    public function update(Request $request, Dog $dog): RedirectResponse
    {
        $this->authorizeOwner($dog);

        $data = $this->validated($request);
        $data = $this->applyPhotos($request, $data, $dog, $dog->owner_id);

        $dog->update($data);

        return redirect()->route('dog.edit', $dog)->with('status', 'Profil psíka uložený.');
    }

    /**
     * Delete a single dog owned by the current user.
     */
    public function destroy(Dog $dog): RedirectResponse
    {
        $this->authorizeOwner($dog);

        $dog->delete();

        return redirect()->route('profile.show')->with('status', 'Psík odstránený.');
    }

    /**
     * Remove one photo (by index) from a dog's gallery.
     */
    public function removePhoto(Request $request, Dog $dog): RedirectResponse
    {
        $this->authorizeOwner($dog);
        $request->validate(['index' => ['required', 'integer', 'min:0']]);

        $photos = $dog->photos ?? [];
        $i = $request->integer('index');

        if (isset($photos[$i])) {
            if (str_starts_with($photos[$i], '/storage/')) {
                Storage::disk('public')->delete(substr($photos[$i], strlen('/storage/')));
            }
            unset($photos[$i]);
            $photos = array_values($photos);

            $dog->photos = $photos;
            $dog->photo_url = $photos[0] ?? null;
            $dog->save();
        }

        return redirect()->route('dog.edit', $dog)->with('status', 'Fotka odstránená.');
    }

    /**
     * Ensure the dog belongs to the current user.
     */
    private function authorizeOwner(Dog $dog): void
    {
        abort_if($dog->owner_id !== Auth::id(), 403);
    }

    /**
     * Validate and normalise the dog form input.
     */
    private function validated(Request $request): array
    {
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
        ], [
            'name.required' => 'Zadaj meno psíka.',
            'gender.required' => 'Vyber pohlavie psíka.',
            'gender.in' => 'Vyber pohlavie psíka.',
            'birth_date.before' => 'Dátum narodenia nemôže byť v budúcnosti.',
            'photos.*.max' => 'Fotka môže mať najviac 5 MB.',
            'photos.*.image' => 'Súbor musí byť obrázok (JPG, PNG).',
        ]);

        $data['vaccinated'] = $request->boolean('vaccinated');
        $data['neutered'] = $request->boolean('neutered');
        $data['microchipped'] = $request->boolean('microchipped');
        $data['vaccinations'] = $data['vaccinated'] ? array_values($request->input('vaccinations', [])) : [];

        return $data;
    }

    /**
     * Merge newly uploaded photos with any existing ones (max 4).
     */
    private function applyPhotos(Request $request, array $data, ?Dog $dog, int $ownerId): array
    {
        $photoPaths = $dog?->photos ?? [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('dog-photos/'.$ownerId, 'public');
                $photoPaths[] = Storage::url($path);
                if (count($photoPaths) >= 4) {
                    break;
                }
            }
        }

        $data['photos'] = array_values(array_slice($photoPaths, 0, 4));
        $data['photo_url'] = $data['photos'][0] ?? null;

        return $data;
    }
}
