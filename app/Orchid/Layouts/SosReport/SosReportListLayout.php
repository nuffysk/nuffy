<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\SosReport;

use App\Models\SosReport;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SosReportListLayout extends Table
{
    protected $target = 'reports';

    protected function columns(): iterable
    {
        return [
            TD::make('id', '#')->sort()->width('50px'),
            TD::make('kind', 'Druh')->sort()->render(fn (SosReport $r) => $r->kind === 'lost' ? 'Stratený' : 'Nájdený'),
            TD::make('status', 'Stav')->sort()->render(fn (SosReport $r) => match ($r->status) {
                'open' => '🟠 Otvorený',
                'in_progress' => '🔵 Riešim',
                'resolved' => '✅ Vyriešený',
                default => $r->status,
            }),
            TD::make('city', 'Mesto'),
            TD::make('description', 'Popis')->render(fn (SosReport $r) => str($r->description)->limit(80)),
            TD::make('contact', 'Kontakt'),
            TD::make('created_at', 'Vytvorené')->sort()->defaultHidden()->render(fn (SosReport $r) => $r->created_at->format('d.m.Y H:i')),
            TD::make('actions')->alignRight()->render(fn (SosReport $r) =>
                Link::make('Upraviť')->route('platform.sos.edit', $r->id)->icon('bs.pencil')
            ),
        ];
    }
}
