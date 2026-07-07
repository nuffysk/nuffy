<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Place;

use App\Models\Place;
use App\Orchid\Layouts\Place\PlaceListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PlaceListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'places' => Place::orderBy('name')->paginate(20),
        ];
    }

    public function name(): ?string { return 'Miesta'; }
    public function description(): ?string { return 'Hotely, salóny, parky, škôlky a reštaurácie pre psíkov.'; }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Pridať miesto')->icon('bs.plus-circle')->route('platform.places.create'),
        ];
    }

    public function layout(): iterable
    {
        return [PlaceListLayout::class];
    }
}
