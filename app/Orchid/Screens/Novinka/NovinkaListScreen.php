<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Novinka;

use App\Models\Novinka;
use App\Orchid\Layouts\Novinka\NovinkaListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class NovinkaListScreen extends Screen
{
    public function query(): iterable
    {
        return ['items' => Novinka::orderByDesc('created_at')->paginate(30)];
    }

    public function name(): ?string { return 'Novinky'; }
    public function description(): ?string { return 'Aktuálne novinky a oznamy pre používateľov.'; }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function commandBar(): iterable
    {
        return [Link::make('Nová novinka')->icon('bs.plus-circle')->route('platform.novinky.create')];
    }

    public function layout(): iterable
    {
        return [NovinkaListLayout::class];
    }
}
