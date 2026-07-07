<?php

declare(strict_types=1);

namespace App\Orchid\Screens\DeletionLog;

use App\Models\DeletionLog;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class DeletionLogListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'logs' => DeletionLog::latest('deleted_at')->paginate(50),
        ];
    }

    public function name(): ?string
    {
        return 'Vymazané účty';
    }

    public function description(): ?string
    {
        return 'Záznam o vymazaní osobných údajov používateľov (GDPR).';
    }

    public function permission(): ?iterable
    {
        return ['platform.systems.users'];
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('logs', [
                TD::make('deleted_at', 'Vymazané')
                    ->render(fn (DeletionLog $l) => optional($l->deleted_at)->format('d.m.Y H:i') ?? '—'),
                TD::make('user_id', 'ID používateľa')
                    ->render(fn (DeletionLog $l) => (string) ($l->user_id ?? '—')),
                TD::make('name', 'Meno')
                    ->render(fn (DeletionLog $l) => e($l->name ?? '—')),
                TD::make('email', 'E-mail')
                    ->render(fn (DeletionLog $l) => e($l->email ?? '—')),
                TD::make('deleted_by', 'Kým')
                    ->render(fn (DeletionLog $l) => match ($l->deleted_by) {
                        'self' => 'Používateľ',
                        'admin' => 'Admin',
                        default => 'Systém',
                    }),
            ]),
        ];
    }
}
