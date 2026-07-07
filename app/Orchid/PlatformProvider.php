<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Prehľad')
                ->icon('bs.house')
                ->title('Ňuffy')
                ->route(config('platform.index')),

            Menu::make('SOS hlásenia')
                ->icon('bs.exclamation-triangle')
                ->route('platform.sos')
                ->permission('platform.content')
                ->badge(fn () => \App\Models\SosReport::where('status', 'open')->count()),

            Menu::make('Žiadosti o pomoc')
                ->icon('bs.heart-pulse')
                ->route('platform.help-reports')
                ->permission('platform.content')
                ->badge(fn () => \App\Models\HelpReport::where('status', 'open')->count()),

            Menu::make('Miesta')
                ->icon('bs.geo-alt')
                ->route('platform.places')
                ->permission('platform.content'),

            Menu::make('Návrhy miest')
                ->icon('bs.geo')
                ->route('platform.place-suggestions')
                ->permission('platform.content'),

            Menu::make('Novinky')
                ->icon('bs.newspaper')
                ->route('platform.novinky')
                ->permission('platform.content'),

            Menu::make('Zavoditko (témy)')
                ->icon('bs.book')
                ->route('platform.learn')
                ->permission('platform.content'),

            Menu::make('Návrhy tém')
                ->icon('bs.lightbulb')
                ->route('platform.topic-requests')
                ->permission('platform.content'),

            Menu::make('Fórum')
                ->icon('bs.chat-square-text')
                ->route('platform.forum')
                ->permission('platform.content')
                ->divider(),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make('Nahlásený obsah')
                ->icon('bs.flag')
                ->route('platform.content-reports')
                ->permission('platform.systems.users')
                ->badge(fn () => \App\Models\ForumReport::where('status', 'open')->count()),

            Menu::make('Vymazané účty')
                ->icon('bs.trash')
                ->route('platform.deletion-logs')
                ->permission('platform.systems.users'),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            ItemPermission::group('Obsah')
                ->addPermission('platform.content', 'Správa obsahu (SOS, miesta, novinky, témy, fórum)'),
        ];
    }
}
