<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearnTopic;

use App\Models\LearnTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class LearnTopicEditScreen extends Screen
{
    public ?LearnTopic $topic = null;
    public bool $exists = false;

    public function query(?LearnTopic $topic = null): iterable
    {
        $this->exists = $topic?->exists ?? false;
        return ['topic' => $topic ?? new LearnTopic(['sort_order' => 100])];
    }

    public function name(): ?string
    {
        return $this->exists ? 'Upraviť tému' : 'Nová téma';
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
                Input::make('topic.title')->title('Názov')->required()->maxlength(120),
                Input::make('topic.slug')->title('Slug')->help('Necháj prázdne pre auto-generovanie')->maxlength(120),
                Input::make('topic.sort_order')->type('number')->title('Poradie'),
                TextArea::make('topic.summary')->title('Anotácia')->rows(2)->maxlength(255),
                TextArea::make('topic.body')->title('Telo článku')->rows(15),
                Input::make('topic.video_url')->title('URL videa')->maxlength(255),
                Cropper::make('topic.thumbnail_url')->title('Náhľadový obrázok')->targetRelativeUrl()->help('Nahraj náhľad témy'),
            ]),
        ];
    }

    public function save(Request $request, ?LearnTopic $topic = null): RedirectResponse
    {
        $data = $request->validate([
            'topic.title' => ['required', 'string', 'max:120'],
            'topic.slug' => ['nullable', 'string', 'max:120'],
            'topic.sort_order' => ['nullable', 'integer'],
            'topic.summary' => ['nullable', 'string', 'max:255'],
            'topic.body' => ['nullable', 'string'],
            'topic.video_url' => ['nullable', 'string', 'max:255'],
            'topic.thumbnail_url' => ['nullable', 'string', 'max:2048'],
        ]);
        $payload = $data['topic'];
        if (empty($payload['slug'])) {
            $payload['slug'] = Str::slug($payload['title']);
        }
        $topic = $topic ?? new LearnTopic();
        $topic->fill($payload)->save();
        Toast::info('Uložené.');
        return redirect()->route('platform.learn');
    }

    public function remove(LearnTopic $topic): RedirectResponse
    {
        $topic->delete();
        Toast::info('Zmazané.');
        return redirect()->route('platform.learn');
    }
}
