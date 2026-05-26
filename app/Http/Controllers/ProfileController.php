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
        $dog = $user->dogs()->first();

        $friends = User::whereIn('id', function ($q) use ($user) {
            $q->select('addressee_id')->from('friendships')
                ->where('requester_id', $user->id)->where('status', 'accepted');
        })->orWhereIn('id', function ($q) use ($user) {
            $q->select('requester_id')->from('friendships')
                ->where('addressee_id', $user->id)->where('status', 'accepted');
        })->get();

        return view('profile.show', compact('user', 'dog', 'friends'));
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
}
