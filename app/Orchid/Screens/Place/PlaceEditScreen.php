<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Place;

use App\Models\Place;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PlaceEditScreen extends Screen
{
    public ?Place $place = null;
    public bool $exists = false;

    public function query(?Place $place = null): iterable
    {
        $this->exists = $place?->exists ?? false;
        return ['place' => $place ?? new Place(['category' => 'gastro'])];
    }

    public function name(): ?string
    {
        return $this->exists ? 'Upraviť miesto' : 'Nové miesto';
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
                Input::make('place.name')->title('Názov')->required()->maxlength(120),
                Select::make('place.category')->title('Kategória')->options([
                    'gastro' => 'Reštaurácia',
                    'park' => 'Park',
                    'kennel' => 'Hotel/Penzión',
                    'daycare' => 'Škôlka',
                    'grooming' => 'Salón',
                    'hotel' => 'Hotel',
                ])->required(),
                Input::make('place.city')->title('Mesto')->maxlength(60),
                Input::make('place.address')->title('Adresa')->maxlength(255),
                Input::make('place.image_url')->title('URL obrázka')->maxlength(255),
                TextArea::make('place.description')->title('Popis')->rows(5),
            ]),
        ];
    }

    public function save(Request $request, ?Place $place = null): RedirectResponse
    {
        $data = $request->validate([
            'place.name' => ['required', 'string', 'max:120'],
            'place.category' => ['required', 'in:gastro,park,kennel,daycare,grooming,hotel'],
            'place.city' => ['nullable', 'string', 'max:60'],
            'place.address' => ['nullable', 'string', 'max:255'],
            'place.image_url' => ['nullable', 'string', 'max:255'],
            'place.description' => ['nullable', 'string'],
        ]);
        $place = $place ?? new Place();
        $place->fill($data['place'])->save();
        Toast::info('Uložené.');
        return redirect()->route('platform.places');
    }

    public function remove(Place $place): RedirectResponse
    {
        $place->delete();
        Toast::info('Zmazané.');
        return redirect()->route('platform.places');
    }
}
