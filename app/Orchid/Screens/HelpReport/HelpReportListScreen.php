<?php

declare(strict_types=1);

namespace App\Orchid\Screens\HelpReport;

use App\Models\HelpReport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class HelpReportListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'reports' => HelpReport::with('reporter:id,name,display_name,email')
                ->latest()
                ->paginate(30),
        ];
    }

    public function name(): ?string
    {
        return 'Žiadosti o pomoc';
    }

    public function description(): ?string
    {
        return 'Psy, ktoré potrebujú pomoc — zranené, opustené alebo hľadajú domov.';
    }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('reports', [
                TD::make('created_at', 'Vytvorené')
                    ->render(fn (HelpReport $r) => optional($r->created_at)->format('d.m.Y H:i') ?? '—'),
                TD::make('need', 'Potreba')
                    ->render(fn (HelpReport $r) => e($r->need ?? '—')),
                TD::make('city', 'Mesto')
                    ->render(fn (HelpReport $r) => e($r->city ?? '—')),
                TD::make('description', 'Popis')
                    ->render(fn (HelpReport $r) => e(Str::limit((string) $r->description, 80))),
                TD::make('contact', 'Kontakt')
                    ->render(fn (HelpReport $r) => e($r->contact ?? '—')),
                TD::make('photo_url', 'Foto')
                    ->render(fn (HelpReport $r) => $r->photo_url
                        ? Link::make('zobraziť')->href($r->photo_url)->target('_blank')
                        : '—'),
                TD::make('reporter', 'Nahlásil')
                    ->render(fn (HelpReport $r) => $r->reporter
                        ? Link::make($r->reporter->display_name ?? $r->reporter->name)
                            ->route('platform.systems.users.edit', $r->reporter_id)
                        : '—'),
                TD::make('status', 'Stav')
                    ->render(fn (HelpReport $r) => $r->status === 'resolved' ? '✅ Vyriešené' : '🟠 Otvorené'),
                TD::make('Akcie')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (HelpReport $r) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Button::make('Označiť ako vyriešené')
                                ->icon('bs.check-circle')
                                ->method('resolve', ['id' => $r->id])
                                ->canSee($r->status !== 'resolved'),
                            Button::make('Zmazať')
                                ->icon('bs.trash3')
                                ->confirm('Naozaj zmazať túto žiadosť o pomoc?')
                                ->method('remove', ['id' => $r->id]),
                        ])),
            ]),
        ];
    }

    public function resolve(Request $request): void
    {
        HelpReport::whereKey($request->get('id'))->update(['status' => 'resolved']);
        Toast::info('Označené ako vyriešené.');
    }

    public function remove(Request $request): void
    {
        HelpReport::findOrFail($request->get('id'))->delete();
        Toast::info('Žiadosť zmazaná.');
    }
}
