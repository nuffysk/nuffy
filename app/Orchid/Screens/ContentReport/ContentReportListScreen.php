<?php

declare(strict_types=1);

namespace App\Orchid\Screens\ContentReport;

use App\Models\ForumComment;
use App\Models\ForumReport;
use App\Models\ForumTopic;
use App\Models\LearnComment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ContentReportListScreen extends Screen
{
    /** target_type → model class. */
    private const TARGETS = [
        'topic' => ForumTopic::class,
        'comment' => ForumComment::class,
        'learn_comment' => LearnComment::class,
    ];

    private const TYPE_LABELS = [
        'topic' => 'Fórum — téma',
        'comment' => 'Fórum — komentár',
        'learn_comment' => 'Zavoditko — komentár',
    ];

    public function query(): iterable
    {
        return [
            'reports' => ForumReport::with('reporter')->latest()->paginate(50),
        ];
    }

    public function name(): ?string
    {
        return 'Nahlásený obsah';
    }

    public function description(): ?string
    {
        return 'Obsah nahlásený používateľmi ako nevhodný.';
    }

    public function permission(): ?iterable
    {
        return ['platform.systems.users'];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('reports', [
                TD::make('created_at', 'Nahlásené')
                    ->render(fn (ForumReport $r) => optional($r->created_at)->format('d.m.Y H:i') ?? '—'),

                TD::make('target_type', 'Typ')
                    ->render(fn (ForumReport $r) => self::TYPE_LABELS[$r->target_type] ?? $r->target_type),

                TD::make('content', 'Obsah')
                    ->render(fn (ForumReport $r) => e(Str::limit($this->targetPreview($r), 90))),

                TD::make('reason', 'Dôvod')
                    ->render(fn (ForumReport $r) => e($r->reason ?? '—')),

                TD::make('reporter', 'Nahlásil')
                    ->render(fn (ForumReport $r) => e($r->reporter->display_name ?? $r->reporter->name ?? ('#'.$r->reporter_id))),

                TD::make('status', 'Stav')
                    ->render(fn (ForumReport $r) => $r->status === 'resolved' ? '✅ Vyriešené' : '🔴 Otvorené'),

                TD::make('Akcie')
                    ->align(TD::ALIGN_CENTER)
                    ->width('120px')
                    ->render(fn (ForumReport $r) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Button::make('Označiť ako vyriešené')
                                ->icon('bs.check-circle')
                                ->method('resolve', ['id' => $r->id])
                                ->canSee($r->status !== 'resolved'),

                            Button::make('Zmazať nahlásený obsah')
                                ->icon('bs.trash3')
                                ->confirm('Naozaj natrvalo zmazať nahlásený obsah? Akcia je nevratná.')
                                ->method('deleteContent', ['id' => $r->id]),

                            Button::make('Zmazať nahlásenie')
                                ->icon('bs.x-circle')
                                ->confirm('Zmazať iba toto nahlásenie (obsah ostane)?')
                                ->method('deleteReport', ['id' => $r->id]),
                        ])),
            ]),
        ];
    }

    public function resolve(Request $request): void
    {
        ForumReport::whereKey($request->get('id'))->update(['status' => 'resolved']);
        Toast::info('Označené ako vyriešené.');
    }

    public function deleteReport(Request $request): void
    {
        ForumReport::findOrFail($request->get('id'))->delete();
        Toast::info('Nahlásenie zmazané.');
    }

    public function deleteContent(Request $request): void
    {
        $report = ForumReport::findOrFail($request->get('id'));
        $class = self::TARGETS[$report->target_type] ?? null;

        if ($class && ($item = $class::find($report->target_id))) {
            $item->delete();
        }

        $report->update(['status' => 'resolved']);
        Toast::info('Obsah zmazaný a nahlásenie vyriešené.');
    }

    /**
     * Load a short text preview of the reported target.
     */
    private function targetPreview(ForumReport $report): string
    {
        $class = self::TARGETS[$report->target_type] ?? null;
        if (! $class) {
            return '—';
        }

        $item = $class::find($report->target_id);
        if (! $item) {
            return '(obsah už neexistuje)';
        }

        return (string) ($item->body ?? $item->title ?? '—');
    }
}
