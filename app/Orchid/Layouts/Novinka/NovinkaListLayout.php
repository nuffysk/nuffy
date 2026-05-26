<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Novinka;

use App\Models\Novinka;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NovinkaListLayout extends Table
{
    protected $target = 'items';

    protected function columns(): iterable
    {
        return [
            TD::make('id', '#')->sort()->width('50px'),
            TD::make('title', 'Názov')->sort(),
            TD::make('slug', 'Slug'),
            TD::make('created_at', 'Vytvorené')->sort()->render(fn (Novinka $n) => $n->created_at->format('d.m.Y H:i')),
            TD::make('actions')->alignRight()->render(fn (Novinka $n) =>
                Link::make('Upraviť')->route('platform.novinky.edit', $n->id)->icon('bs.pencil')
            ),
        ];
    }
}
