<?php

declare(strict_types=1);

namespace App\Orchid\Screens\PlaceSuggestion;

use App\Models\Place;
use App\Models\PlaceSuggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PlaceSuggestionListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'suggestions' => PlaceSuggestion::with('user:id,name,display_name')
                ->orderByDesc('id')
                ->paginate(30),
        ];
    }

    public function name(): ?string
    {
        return 'Návrhy miest';
    }

    public function description(): ?string
    {
        return 'Miesta navrhnuté používateľmi. Prijatím sa vytvorí nové miesto na doladenie.';
    }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('suggestions', [
                TD::make('created_at', 'Vytvorené')
                    ->render(fn (PlaceSuggestion $s) => optional($s->created_at)->format('d.m.Y H:i') ?? '—'),
                TD::make('name', 'Názov')
                    ->render(fn (PlaceSuggestion $s) => e($s->name ?? '—')),
                TD::make('category', 'Kategória')
                    ->render(fn (PlaceSuggestion $s) => e($s->category ?? '—')),
                TD::make('city', 'Mesto')
                    ->render(fn (PlaceSuggestion $s) => e($s->city ?? '—')),
                TD::make('note', 'Poznámka')
                    ->render(fn (PlaceSuggestion $s) => e(Str::limit((string) $s->note, 60))),
                TD::make('user', 'Navrhol')
                    ->render(fn (PlaceSuggestion $s) => $s->user
                        ? Link::make($s->user->display_name ?? $s->user->name)
                            ->route('platform.systems.users.edit', $s->user_id)
                        : '—'),
                TD::make('Akcie')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (PlaceSuggestion $s) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Button::make('Prijať → vytvoriť miesto')
                                ->icon('bs.check-circle')
                                ->confirm('Vytvoriť z návrhu nové miesto? Návrh sa potom zmaže.')
                                ->method('accept', ['id' => $s->id]),
                            Button::make('Zamietnuť (zmazať)')
                                ->icon('bs.trash3')
                                ->confirm('Naozaj zmazať tento návrh?')
                                ->method('remove', ['id' => $s->id]),
                        ])),
            ]),
        ];
    }

    /**
     * Accept a suggestion: create a draft Place from it, then remove the suggestion.
     */
    public function accept(Request $request)
    {
        $suggestion = PlaceSuggestion::findOrFail($request->get('id'));

        $place = Place::create([
            'name' => $suggestion->name ?: 'Nové miesto',
            'category' => $suggestion->category,
            'city' => $suggestion->city,
            'description' => $suggestion->note,
        ]);

        $suggestion->delete();

        Toast::info('Miesto vytvorené — doplň detaily.');

        return redirect()->route('platform.places.edit', $place);
    }

    public function remove(Request $request): void
    {
        PlaceSuggestion::findOrFail($request->get('id'))->delete();
        Toast::info('Návrh zmazaný.');
    }
}
