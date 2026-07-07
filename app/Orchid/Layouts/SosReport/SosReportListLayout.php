<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\SosReport;

use App\Models\SosReport;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SosReportListLayout extends Table
{
    protected $target = 'reports';

    protected function columns(): iterable
    {
        return [
            TD::make('id', '#')->sort()->width('50px'),
            TD::make('kind', 'Druh')->sort()
                ->filter(Select::make()->options(['found' => 'Nájdený', 'lost' => 'Stratený'])->empty('—'))
                ->render(fn (SosReport $r) => $r->kind === 'lost' ? 'Stratený' : 'Nájdený'),
            TD::make('status', 'Stav')->sort()
                ->filter(Select::make()->options(['open' => 'Otvorený', 'in_progress' => 'Riešim', 'resolved' => 'Vyriešený'])->empty('—'))
                ->render(fn (SosReport $r) => match ($r->status) {
                'open' => '🟠 Otvorený',
                'in_progress' => '🔵 Riešim',
                'resolved' => '✅ Vyriešený',
                default => $r->status,
            }),
            TD::make('city', 'Mesto')->sort()->filter(Input::make()),
            TD::make('reporter', 'Nahlásil')->render(fn (SosReport $r) => $r->reporter
                ? Link::make($r->reporter->display_name ?? $r->reporter->name)
                    ->route('platform.systems.users.edit', $r->reporter_id)
                : '—'),
            TD::make('description', 'Popis')->render(fn (SosReport $r) => str($r->description)->limit(80)),
            TD::make('contact', 'Kontakt'),
            TD::make('phone', 'Telefón')->render(fn (SosReport $r) => $r->phone ?: '—'),
            TD::make('created_at', 'Vytvorené')->sort()->render(fn (SosReport $r) => $r->created_at->format('d.m.Y H:i')),
            TD::make('actions')->alignRight()->render(fn (SosReport $r) =>
                Link::make('Upraviť')->route('platform.sos.edit', $r->id)->icon('bs.pencil')
            ),
        ];
    }
}
