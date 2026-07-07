<?php

declare(strict_types=1);

namespace App\Orchid\Screens\SosReport;

use App\Models\SosReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SosReportEditScreen extends Screen
{
    public ?SosReport $report = null;

    public function query(SosReport $report): iterable
    {
        $report->load('reporter');

        return ['report' => $report];
    }

    public function name(): ?string { return 'SOS hlásenie #'.$this->report?->id; }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Uložiť')->method('save')->icon('bs.save'),
            Button::make('Zmazať')->method('remove')->icon('bs.trash')->confirm('Naozaj zmazať?'),
        ];
    }

    public function layout(): iterable
    {
        $reporter = $this->report?->reporter;

        return [
            Layout::rows([
                Label::make('reporter_info')
                    ->title('Nahlásil')
                    ->value($reporter
                        ? ($reporter->display_name ?? $reporter->name).' ('.$reporter->email.')'
                        : '—'),
                Select::make('report.kind')->title('Druh')->options(['found' => 'Nájdený', 'lost' => 'Stratený']),
                Select::make('report.status')->title('Stav')->options(['open' => 'Otvorený', 'in_progress' => 'Riešim', 'resolved' => 'Vyriešený']),
                Input::make('report.city')->title('Mesto')->maxlength(60),
                TextArea::make('report.description')->title('Popis')->rows(5)->required(),
                Input::make('report.contact')->title('Kontakt')->maxlength(120),
                Input::make('report.phone')->title('Telefón')->maxlength(30)
                    ->help('Zverejnené so súhlasom nahlasovateľa.'),
                Input::make('report.instagram')->title('Instagram')->maxlength(60),
                Cropper::make('report.photo_url')->title('Fotka')->targetRelativeUrl()->help('Nahraj fotku'),
            ]),
        ];
    }

    public function save(Request $request, SosReport $report): RedirectResponse
    {
        $data = $request->validate([
            'report.kind' => ['required', 'in:found,lost'],
            'report.status' => ['required', 'in:open,in_progress,resolved'],
            'report.city' => ['nullable', 'string', 'max:60'],
            'report.description' => ['required', 'string'],
            'report.contact' => ['nullable', 'string', 'max:120'],
            'report.phone' => ['nullable', 'string', 'max:30'],
            'report.instagram' => ['nullable', 'string', 'max:60'],
            'report.photo_url' => ['nullable', 'string', 'max:2048'],
        ]);
        $report->fill($data['report'])->save();
        Toast::info('Uložené.');
        return redirect()->route('platform.sos');
    }

    public function remove(SosReport $report): RedirectResponse
    {
        $report->delete();
        Toast::info('Zmazané.');
        return redirect()->route('platform.sos');
    }
}
