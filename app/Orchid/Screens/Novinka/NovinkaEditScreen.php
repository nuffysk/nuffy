<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Novinka;

use App\Models\Novinka;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NovinkaEditScreen extends Screen
{
    public ?Novinka $novinka = null;
    public bool $exists = false;

    public function query(?Novinka $novinka = null): iterable
    {
        $this->exists = $novinka?->exists ?? false;
        return ['novinka' => $novinka ?? new Novinka()];
    }

    public function name(): ?string
    {
        return $this->exists ? 'Upraviť novinku' : 'Nová novinka';
    }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function commandBar(): iterable
    {
        $buttons = [Button::make('Uložiť')->method('save')->icon('bs.save')];
        if ($this->exists) {
            $buttons[] = Button::make('Zmazať')->method('remove')->icon('bs.trash')->confirm('Naozaj zmazať?');
        }
        return $buttons;
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('novinka.title')->title('Názov')->required()->maxlength(140),
                Input::make('novinka.slug')->title('Slug')->help('Necháj prázdne pre auto-generovanie')->maxlength(120),
                TextArea::make('novinka.content')->title('Obsah')->required()->rows(15),
            ]),
        ];
    }

    public function save(Request $request, ?Novinka $novinka = null): RedirectResponse
    {
        $data = $request->validate([
            'novinka.title' => ['required', 'string', 'max:140'],
            'novinka.slug' => ['nullable', 'string', 'max:120'],
            'novinka.content' => ['required', 'string'],
        ]);
        $payload = $data['novinka'];
        if (empty($payload['slug'])) {
            $slug = Str::slug($payload['title']) ?: 'n-'.time();
            if (Novinka::where('slug', $slug)->where('id', '!=', $novinka?->id)->exists()) {
                $slug .= '-'.base_convert(time(), 10, 36);
            }
            $payload['slug'] = $slug;
        }
        if (! $novinka) {
            $payload['author_id'] = Auth::id();
        }
        $novinka = $novinka ?? new Novinka();
        $novinka->fill($payload)->save();
        Toast::info('Uložené.');
        return redirect()->route('platform.novinky');
    }

    public function remove(Novinka $novinka): RedirectResponse
    {
        $novinka->delete();
        Toast::info('Zmazané.');
        return redirect()->route('platform.novinky');
    }
}
