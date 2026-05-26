<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\LearnTopic;

use App\Models\LearnTopic;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LearnTopicListLayout extends Table
{
    protected $target = 'topics';

    protected function columns(): iterable
    {
        return [
            TD::make('sort_order', 'Poradie')->sort()->width('80px'),
            TD::make('title', 'Názov')->sort(),
            TD::make('slug', 'Slug'),
            TD::make('summary', 'Anotácia')->render(fn (LearnTopic $t) => str($t->summary)->limit(80)),
            TD::make('actions')->alignRight()->render(fn (LearnTopic $t) =>
                Link::make('Upraviť')->route('platform.learn.edit', $t->id)->icon('bs.pencil')
            ),
        ];
    }
}
