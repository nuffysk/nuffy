<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearnTopic;

use App\Models\LearnTopic;
use App\Orchid\Layouts\LearnTopic\LearnTopicListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class LearnTopicListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'topics' => LearnTopic::orderBy('sort_order')->paginate(30),
        ];
    }

    public function name(): ?string { return 'Zavoditko — témy'; }
    public function description(): ?string { return 'Vzdelávacie články pre majiteľov psíkov.'; }

    public function commandBar(): iterable
    {
        return [Link::make('Nová téma')->icon('bs.plus-circle')->route('platform.learn.create')];
    }

    public function layout(): iterable
    {
        return [LearnTopicListLayout::class];
    }
}
