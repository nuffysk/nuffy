@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm text-foreground hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>
        <h1 class="mt-4 font-display text-3xl">Profil</h1>

        @if (session('status'))
            <p class="mt-2 text-sm text-accent">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf
            @method('PATCH')

            <div class="space-y-2">
                <label class="text-sm font-medium">Avatar</label>
                <div class="flex items-center gap-4">
                    <div class="h-20 w-20 overflow-hidden rounded-full bg-card ring-1 ring-border">
                        @if ($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <input type="file" name="avatar" accept="image/*" class="block flex-1 text-sm">
                </div>
                @error('avatar')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="display_name" class="text-sm font-medium">Meno a priezvisko</label>
                <input id="display_name" name="display_name" type="text" value="{{ old('display_name', $user->display_name ?? $user->name) }}" required maxlength="60" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('display_name')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <span class="text-sm font-medium">Pohlavie</span>
                <div class="grid grid-cols-3 gap-2">
                    @foreach (['female' => 'Žena', 'male' => 'Muž', 'unspecified' => 'Neuvádzam'] as $val => $label)
                        <label class="flex cursor-pointer items-center justify-center rounded-xl border border-input bg-background px-3 py-2 text-sm has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)]">
                            <input type="radio" name="gender" value="{{ $val }}" {{ old('gender', $user->gender) === $val ? 'checked' : '' }} class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-2">
                <label for="city" class="text-sm font-medium">Mesto</label>
                <input id="city" name="city" type="text" maxlength="60" value="{{ old('city', $user->city) }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
            </div>

            <div class="space-y-2">
                <label for="instagram" class="text-sm font-medium">Instagram (voliteľné)</label>
                <input id="instagram" name="instagram" type="text" maxlength="60" placeholder="@nuffy.sk" value="{{ old('instagram', $user->instagram) }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('instagram')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="bio" class="text-sm font-medium">O mne</label>
                <textarea id="bio" name="bio" rows="4" maxlength="500" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">Uložiť</button>
        </form>
    </div>
@endsection
