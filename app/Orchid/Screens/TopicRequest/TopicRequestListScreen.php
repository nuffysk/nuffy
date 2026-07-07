<?php

declare(strict_types=1);

namespace App\Orchid\Screens\TopicRequest;

use App\Models\TopicRequest;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TopicRequestListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'requests' => TopicRequest::with('user:id,name,display_name')
                ->orderByDesc('id')
                ->paginate(30),
        ];
    }

    public function name(): ?string
    {
        return 'Návrhy tém (Zavoditko)';
    }

    public function description(): ?string
    {
        return 'Témy, ktoré by používatelia chceli vidieť v sekcii Zavoditko.';
    }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Nová téma')
                ->icon('bs.plus-circle')
                ->route('platform.learn.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('requests', [
                TD::make('created_at', 'Vytvorené')
                    ->render(fn (TopicRequest $t) => optional($t->created_at)->format('d.m.Y H:i') ?? '—'),
                TD::make('suggestion', 'Návrh')
                    ->render(fn (TopicRequest $t) => e($t->suggestion)),
                TD::make('user', 'Navrhol')
                    ->render(fn (TopicRequest $t) => $t->user
                        ? Link::make($t->user->display_name ?? $t->user->name)
                            ->route('platform.systems.users.edit', $t->user_id)
                        : '—'),
                TD::make('Akcie')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (TopicRequest $t) => Button::make('Zmazať')
                        ->icon('bs.trash3')
                        ->confirm('Naozaj zmazať tento návrh?')
                        ->method('remove', ['id' => $t->id])),
            ]),
        ];
    }

    public function remove(Request $request): void
    {
        TopicRequest::findOrFail($request->get('id'))->delete();
        Toast::info('Návrh zmazaný.');
    }
}
