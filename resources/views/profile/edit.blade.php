@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Profil</h1>
        <p class="mt-1 text-sm text-muted-foreground">Tvoje údaje, ktoré vidia ostatní</p>

        @if (session('status'))
            <p class="mt-2 text-sm text-accent">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-4 space-y-5">
            @csrf
            @method('PATCH')

            <div class="flex items-center gap-4">
                <div class="relative h-24 w-24 overflow-hidden rounded-3xl bg-muted">
                    @if ($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="" class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="flex flex-col gap-1">
                    <label class="cursor-pointer text-sm text-accent underline-offset-4 hover:underline">
                        Zmeniť fotku
                        <input type="file" name="avatar" accept="image/*" class="hidden">
                    </label>
                    <p class="text-[11px] leading-relaxed text-muted-foreground">
                        Nahraním fotky súhlasíš so spracovaním osobných údajov a jej zverejnením v rámci aplikácie.
                    </p>
                    @error('avatar')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-2">
                <label for="display_name" class="text-sm font-medium">Meno</label>
                <input id="display_name" name="display_name" type="text" value="{{ old('display_name', $user->display_name ?? $user->name) }}" required maxlength="60" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('display_name')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium">Pohlavie</label>
                <div class="flex gap-2">
                    @foreach (['male' => 'Muž', 'female' => 'Žena', 'unspecified' => 'Neuvádzam'] as $val => $label)
                        <label @class([
                            'flex flex-1 cursor-pointer items-center justify-center rounded-full border px-3 py-2 text-sm transition',
                            'has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)] has-[:checked]:text-accent',
                            'border-border bg-card text-muted-foreground',
                        ])>
                            <input type="radio" name="gender" value="{{ $val }}" {{ old('gender', $user->gender) === $val ? 'checked' : '' }} class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-2">
                <label for="city" class="text-sm font-medium">Mesto</label>
                <input id="city" name="city" type="text" maxlength="60" placeholder="Bratislava" value="{{ old('city', $user->city) }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
            </div>

            <div class="space-y-2">
                <label for="instagram" class="text-sm font-medium">Instagram</label>
                <input id="instagram" name="instagram" type="text" maxlength="60" placeholder="instagram_účet" value="{{ old('instagram', $user->instagram) }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('instagram')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="bio" class="text-sm font-medium">Bio</label>
                <textarea id="bio" name="bio" rows="4" maxlength="500" placeholder="Ranný chodec, kávičkár, pri každom psíkovi zastavím." class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">Uložiť</button>
                <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center rounded-2xl px-6 py-3 text-base font-medium text-muted-foreground transition hover:bg-muted hover:text-foreground">Späť</a>
            </div>
        </form>
    </div>
@endsection
