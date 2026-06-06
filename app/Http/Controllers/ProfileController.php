<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        $dogs = $user->dogs()->get();

        $friends = User::whereIn('id', function ($q) use ($user) {
            $q->select('addressee_id')->from('friendships')
                ->where('requester_id', $user->id)->where('status', 'accepted');
        })->orWhereIn('id', function ($q) use ($user) {
            $q->select('requester_id')->from('friendships')
                ->where('addressee_id', $user->id)->where('status', 'accepted');
        })->get();

        return view('profile.show', compact('user', 'dogs', 'friends'));
    }

    public function edit(): View
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:60'],
            'city' => ['nullable', 'string', 'max:60'],
            'gender' => ['required', 'in:male,female,unspecified'],
            'bio' => ['nullable', 'string', 'max:500'],
            'instagram' => ['nullable', 'string', 'max:60'],
            'avatar' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_url && str_starts_with($user->avatar_url, '/storage/')) {
                Storage::disk('public')->delete(substr($user->avatar_url, strlen('/storage/')));
            }
            $path = $request->file('avatar')->store('avatars/'.$user->id, 'public');
            $data['avatar_url'] = Storage::url($path);
        }

        unset($data['avatar']);
        $user->update($data);

        return redirect()->route('profile.show')->with('status', 'Profil uložený.');
    }

    public function addWithDogPhoto(Request $request): RedirectResponse
    {
        $request->validate(['photo' => ['required', 'image', 'max:5120']]);
        $user = Auth::user();

        $photos = $user->with_dog_photos ?? [];
        if (count($photos) >= 4) {
            return back()->with('status', 'Maximálne 4 fotky.');
        }

        $path = $request->file('photo')->store('avatars/'.$user->id, 'public');
        $photos[] = Storage::url($path);
        $user->with_dog_photos = $photos;
        $user->save();

        return back()->with('status', 'Fotka pridaná.');
    }

    public function removeWithDogPhoto(Request $request): RedirectResponse
    {
        $request->validate(['index' => ['required', 'integer', 'min:0']]);
        $user = Auth::user();

        $photos = $user->with_dog_photos ?? [];
        $i = $request->integer('index');
        if (isset($photos[$i])) {
            if (str_starts_with($photos[$i], '/storage/')) {
                Storage::disk('public')->delete(substr($photos[$i], strlen('/storage/')));
            }
            array_splice($photos, $i, 1);
            $user->with_dog_photos = array_values($photos);
            $user->save();
        }

        return back()->with('status', 'Fotka odstránená.');
    }
}
