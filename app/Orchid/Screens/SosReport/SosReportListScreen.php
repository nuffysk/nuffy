<?php

declare(strict_types=1);

namespace App\Orchid\Screens\SosReport;

use App\Models\SosReport;
use App\Orchid\Layouts\SosReport\SosReportListLayout;
use Orchid\Screen\Screen;

class SosReportListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'reports' => SosReport::with('reporter:id,name,display_name')
                ->filters()
                ->defaultSort('created_at', 'desc')
                ->paginate(20),
        ];
    }

    public function name(): ?string { return 'SOS hlásenia'; }
    public function description(): ?string { return 'Stratené a nájdené psy nahlásené používateľmi.'; }

    public function permission(): ?iterable
    {
        return ['platform.content'];
    }

    public function commandBar(): iterable { return []; }

    public function layout(): iterable
    {
        return [SosReportListLayout::class];
    }
}
