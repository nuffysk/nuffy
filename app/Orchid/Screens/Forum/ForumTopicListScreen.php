<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Forum;

use App\Models\ForumTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ForumTopicListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'topics' => ForumTopic::with('author:id,name,display_name')
                ->withCount('comments')
                ->orderByDesc('pinned')
                ->latest()
                ->paginate(30),
        ];
    }

    public function name(): ?string
    {
        return 'Fórum — moderovanie';
    }

    public function description(): ?string
    {
        return 'Témy fóra: pripnutie, mazanie a prehľad diskusie.';
    }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('topics', [
                TD::make('created_at', 'Vytvorené')
                    ->render(fn (ForumTopic $t) => optional($t->created_at)->format('d.m.Y H:i') ?? '—'),
                TD::make('title', 'Názov')
                    ->render(fn (ForumTopic $t) => Link::make(Str::limit((string) $t->title, 60))
                        ->href(route('walks.show', $t))
                        ->target('_blank')),
                TD::make('author', 'Autor')
                    ->render(fn (ForumTopic $t) => $t->author
                        ? Link::make($t->author->display_name ?? $t->author->name)
                            ->route('platform.systems.users.edit', $t->author_id)
                        : '—'),
                TD::make('comments_count', 'Komentáre')
                    ->align(TD::ALIGN_CENTER)
                    ->render(fn (ForumTopic $t) => (string) $t->comments_count),
                TD::make('pinned', 'Pripnuté')
                    ->align(TD::ALIGN_CENTER)
                    ->render(fn (ForumTopic $t) => $t->pinned ? '📌 Áno' : '—'),
                TD::make('Akcie')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (ForumTopic $t) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Button::make($t->pinned ? 'Odopnúť' : 'Pripnúť')
                                ->icon('bs.pin-angle')
                                ->method('togglePin', ['id' => $t->id]),
                            Button::make('Zmazať tému')
                                ->icon('bs.trash3')
                                ->confirm('Naozaj zmazať tému aj s komentármi? Akcia je nevratná.')
                                ->method('remove', ['id' => $t->id]),
                        ])),
            ]),
        ];
    }

    public function togglePin(Request $request): void
    {
        $topic = ForumTopic::findOrFail($request->get('id'));
        $topic->update(['pinned' => ! $topic->pinned]);
        Toast::info($topic->pinned ? 'Téma pripnutá.' : 'Téma odopnutá.');
    }

    public function remove(Request $request): void
    {
        $topic = ForumTopic::findOrFail($request->get('id'));
        $topic->comments()->delete();
        $topic->delete();
        Toast::info('Téma zmazaná.');
    }
}
