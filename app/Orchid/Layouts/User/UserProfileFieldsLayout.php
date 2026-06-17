<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class UserProfileFieldsLayout extends Rows
{
    /**
     * Nuffy-specific profile fields the user fills in on /profile/edit.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.display_name')
                ->type('text')
                ->maxlength(60)
                ->title('Zobrazené meno')
                ->placeholder('Zobrazené meno'),

            Select::make('user.gender')
                ->options([
                    'male' => 'Muž',
                    'female' => 'Žena',
                    'unspecified' => 'Neuvádza',
                ])
                ->empty('—')
                ->title('Pohlavie'),

            Input::make('user.city')
                ->type('text')
                ->maxlength(60)
                ->title('Mesto'),

            Input::make('user.instagram')
                ->type('text')
                ->maxlength(60)
                ->title('Instagram')
                ->placeholder('instagram_účet'),

            Input::make('user.birth_year')
                ->type('number')
                ->min(1900)
                ->max((int) date('Y'))
                ->title('Rok narodenia'),

            TextArea::make('user.bio')
                ->rows(4)
                ->maxlength(500)
                ->title('Bio'),

            Input::make('user.avatar_url')
                ->type('text')
                ->maxlength(2048)
                ->title('Avatar URL')
                ->help('Cesta k profilovej fotke (napr. /storage/avatars/…)'),
        ];
    }
}
