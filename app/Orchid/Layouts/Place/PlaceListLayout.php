<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Place;

use App\Models\Place;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PlaceListLayout extends Table
{
    protected $target = 'places';

    protected function columns(): iterable
    {
        return [
            TD::make('id', '#')->sort()->width('50px'),
            TD::make('name', 'Názov')->sort(),
            TD::make('category', 'Kategória')->sort()->render(fn (Place $p) => match ($p->category) {
                'gastro' => 'Reštaurácia',
                'park' => 'Park',
                'kennel' => 'Hotel',
                'daycare' => 'Škôlka',
                'grooming' => 'Salón',
                'hotel' => 'Hotel',
                default => $p->category,
            }),
            TD::make('city', 'Mesto')->sort(),
            TD::make('address', 'Adresa'),
            TD::make('actions')->alignRight()->render(fn (Place $p) =>
                Link::make('Upraviť')->route('platform.places.edit', $p->id)->icon('bs.pencil')
            ),
        ];
    }
}
