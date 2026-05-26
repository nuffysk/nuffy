@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ vaccinated: {{ old('vaccinated', $dog->vaccinated ? 1 : 0) }} }">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm text-foreground hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>
        <h1 class="mt-4 font-display text-3xl">Profil ňuffka</h1>

        @if (session('status'))
            <p class="mt-2 text-sm text-accent">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('dog.save') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf

            <div class="space-y-2">
                <label for="name" class="text-sm font-medium">Meno</label>
                <input id="name" name="name" type="text" maxlength="40" required value="{{ old('name', $dog->name) }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('name')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <span class="text-sm font-medium">Pohlavie</span>
                <div class="grid grid-cols-2 gap-2">
                    @foreach (['male' => 'Chlapček', 'female' => 'Dievčatko'] as $val => $label)
                        <label class="flex cursor-pointer items-center justify-center rounded-xl border border-input bg-background px-3 py-2 text-sm has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)]">
                            <input type="radio" name="gender" value="{{ $val }}" {{ old('gender', $dog->gender) === $val ? 'checked' : '' }} class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium">Fotky (max 4)</label>
                @php $existingPhotos = $dog->photos ?? []; @endphp
                <div class="grid grid-cols-4 gap-2">
                    @for ($i = 0; $i < 4; $i++)
                        @php $photo = $existingPhotos[$i] ?? null; @endphp
                        <div class="aspect-square overflow-hidden rounded-2xl border border-border bg-muted">
                            @if ($photo)<img src="{{ $photo }}" alt="" class="h-full w-full object-cover">@endif
                        </div>
                    @endfor
                </div>
                <input type="file" name="photos[]" accept="image/*" multiple class="block w-full text-sm">
                @error('photos.*')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-2">
                    <label for="birth_date" class="text-sm font-medium">Dátum narodenia</label>
                    <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', optional($dog->birth_date)->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                </div>
                <div class="space-y-2">
                    <label for="breed" class="text-sm font-medium">Plemeno</label>
                    <input id="breed" name="breed" type="text" maxlength="60" value="{{ old('breed', $dog->breed) }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                </div>
            </div>

            <div class="space-y-2">
                <span class="text-sm font-medium">Veľkosť</span>
                <div class="grid grid-cols-3 gap-2">
                    @foreach (['small' => ['Malá', 'pod 14 kg'], 'medium' => ['Stredná', '14–30 kg'], 'large' => ['Veľká', 'nad 30 kg']] as $val => $labelPair)
                        <label class="flex cursor-pointer flex-col items-center justify-center rounded-xl border border-input bg-background px-3 py-2 text-xs has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)]">
                            <input type="radio" name="size" value="{{ $val }}" {{ old('size', $dog->size) === $val ? 'checked' : '' }} class="sr-only">
                            <span class="font-medium">{{ $labelPair[0] }}</span>
                            <span class="text-[10px] text-muted-foreground">{{ $labelPair[1] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            @foreach ([
                ['name' => 'neutered', 'label' => 'Psík je kastrovaný?'],
                ['name' => 'microchipped', 'label' => 'Má pes mikročip?'],
            ] as $bool)
                <div class="space-y-2">
                    <span class="text-sm font-medium">{{ $bool['label'] }}</span>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ([1 => 'Áno', 0 => 'Nie'] as $val => $label)
                            <label class="flex cursor-pointer items-center justify-center rounded-xl border border-input bg-background px-3 py-2 text-sm has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)]">
                                <input type="radio" name="{{ $bool['name'] }}" value="{{ $val }}" {{ (string) old($bool['name'], $dog->{$bool['name']} ? 1 : 0) === (string) $val ? 'checked' : '' }} class="sr-only">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="space-y-2">
                <span class="text-sm font-medium">Psík je očkovaný?</span>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ([1 => 'Áno', 0 => 'Nie'] as $val => $label)
                        <label class="flex cursor-pointer items-center justify-center rounded-xl border border-input bg-background px-3 py-2 text-sm has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)]">
                            <input type="radio" name="vaccinated" value="{{ $val }}" {{ (string) old('vaccinated', $dog->vaccinated ? 1 : 0) === (string) $val ? 'checked' : '' }} x-model.number="vaccinated" class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                <div x-show="vaccinated === 1" class="space-y-2 pt-2">
                    @foreach (['Infekčné ochorenia', 'Besnota', 'Kotercový kašeľ'] as $vacc)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="vaccinations[]" value="{{ $vacc }}" {{ in_array($vacc, old('vaccinations', $dog->vaccinations ?? [])) ? 'checked' : '' }} class="rounded border-border text-accent focus:ring-accent">
                            {{ $vacc }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-2">
                <label for="vet" class="text-sm font-medium">Náš veterinár</label>
                <input id="vet" name="vet" type="text" maxlength="120" value="{{ old('vet', $dog->vet) }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
            </div>

            <div class="space-y-2">
                <label for="personality" class="text-sm font-medium">Bio psa</label>
                <textarea id="personality" name="personality" rows="4" maxlength="300" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">{{ old('personality', $dog->personality) }}</textarea>
            </div>

            <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">Uložiť</button>
        </form>

        @if ($dog->exists)
            <form method="POST" action="{{ route('dog.destroy') }}" class="mt-6" onsubmit="return confirm('Naozaj odstrániť psíka?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl border border-destructive bg-card px-6 py-3 text-base font-medium text-destructive">Odstrániť psíka</button>
            </form>
        @endif
    </div>
@endsection
