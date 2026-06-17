<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\Dog;
use App\Models\ForumComment;
use App\Models\ForumTopic;
use App\Models\Friendship;
use App\Models\HelpReport;
use App\Models\LearnComment;
use App\Models\PlaceSuggestion;
use App\Models\Post;
use App\Models\SosReport;
use App\Models\TopicRequest;
use App\Models\User;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\Orchid\Layouts\User\UserProfileFieldsLayout;
use App\Orchid\Layouts\User\UserRoleLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Orchid\Access\Impersonation;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserEditScreen extends Screen
{
    /**
     * @var User
     */
    public $user;

    /**
     * Map of moderatable models the admin can delete from this screen.
     * Key = identifier used in the delete button, value = model class.
     */
    private const MODERATABLE = [
        'Dog' => Dog::class,
        'Post' => Post::class,
        'SosReport' => SosReport::class,
        'HelpReport' => HelpReport::class,
        'LearnComment' => LearnComment::class,
        'PlaceSuggestion' => PlaceSuggestion::class,
        'TopicRequest' => TopicRequest::class,
        'Friendship' => Friendship::class,
        'ForumTopic' => ForumTopic::class,
        'ForumComment' => ForumComment::class,
    ];

    /**
     * Fetch data to be displayed on the screen.
     */
    public function query(User $user): iterable
    {
        $user->load(['roles']);

        $uid = $user->id;

        return [
            'user'       => $user,
            'permission' => $user->statusOfPermissions(),

            // Everything the user has created (for moderation / overview).
            'dogs'             => $uid ? Dog::where('owner_id', $uid)->latest()->get() : collect(),
            'posts'            => $uid ? Post::where('author_id', $uid)->latest()->get() : collect(),
            'sos'              => $uid ? SosReport::where('reporter_id', $uid)->latest()->get() : collect(),
            'help'             => $uid ? HelpReport::where('reporter_id', $uid)->latest()->get() : collect(),
            'learnComments'    => $uid ? LearnComment::where('author_id', $uid)->latest()->get() : collect(),
            'placeSuggestions' => $uid ? PlaceSuggestion::where('user_id', $uid)->latest()->get() : collect(),
            'topicRequests'    => $uid ? TopicRequest::where('user_id', $uid)->latest()->get() : collect(),
            'friendships'      => $uid ? Friendship::with(['requester', 'addressee'])
                ->where('requester_id', $uid)->orWhere('addressee_id', $uid)->latest()->get() : collect(),
            'forumTopics'      => $uid ? ForumTopic::where('author_id', $uid)->latest()->get() : collect(),
            'forumComments'    => $uid ? ForumComment::where('author_id', $uid)->latest()->get() : collect(),
        ];
    }

    public function name(): ?string
    {
        return $this->user->exists ? 'Upraviť používateľa' : 'Nový používateľ';
    }

    public function description(): ?string
    {
        return 'Profil, prístupy a všetok obsah, ktorý používateľ zadal.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Impersonate user'))
                ->icon('bs.box-arrow-in-right')
                ->confirm(__('You can revert to your original state by logging out.'))
                ->method('loginAs')
                ->canSee($this->user->exists && $this->user->id !== \request()->user()->id),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->user->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        $saveCommand = fn () => Button::make(__('Save'))
            ->type(Color::BASIC)
            ->icon('bs.check-circle')
            ->canSee($this->user->exists)
            ->method('save');

        return [
            Layout::block(UserProfileFieldsLayout::class)
                ->title('Nuffy profil')
                ->description('Profilové údaje, ktoré používateľ vyplnil v aplikácii.')
                ->commands($saveCommand()),

            Layout::block(UserEditLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Meno a e-mailová adresa účtu.'))
                ->commands($saveCommand()),

            Layout::block(UserPasswordLayout::class)
                ->title(__('Password'))
                ->description(__('Nastav používateľovi nové heslo.'))
                ->commands($saveCommand()),

            Layout::block(UserRoleLayout::class)
                ->title(__('Roles'))
                ->description(__('Roly definujú, čo používateľ smie robiť.'))
                ->commands($saveCommand()),

            Layout::block(RolePermissionLayout::class)
                ->title(__('Permissions'))
                ->description(__('Dodatočné individuálne práva nad rámec rolí.'))
                ->commands($saveCommand()),

            Layout::tabs([
                'Psy' => $this->contentTable('dogs', 'Dog', [
                    TD::make('name', 'Meno')->render(fn (Dog $d) => e($d->name)),
                    TD::make('breed', 'Plemeno')->render(fn (Dog $d) => e($d->breed ?? '—')),
                    TD::make('size', 'Veľkosť')->render(fn (Dog $d) => e($d->size ?? '—')),
                    TD::make('gender', 'Pohlavie')->render(fn (Dog $d) => e($d->gender ?? '—')),
                    TD::make('vaccinated', 'Očkovaný')->render(fn (Dog $d) => $d->vaccinated ? 'Áno' : 'Nie'),
                ]),
                'Príspevky' => $this->contentTable('posts', 'Post', [
                    TD::make('caption', 'Popis')->render(fn (Post $p) => e(Str::limit((string) $p->caption, 60) ?: '—')),
                    TD::make('image_url', 'Foto')->render(fn (Post $p) => $p->image_url
                        ? Link::make('zobraziť')->href($p->image_url)->target('_blank')
                        : '—'),
                ]),
                'SOS' => $this->contentTable('sos', 'SosReport', [
                    TD::make('kind', 'Typ')->render(fn (SosReport $r) => e($r->kind ?? '—')),
                    TD::make('city', 'Mesto')->render(fn (SosReport $r) => e($r->city ?? '—')),
                    TD::make('description', 'Popis')->render(fn (SosReport $r) => e(Str::limit((string) $r->description, 60))),
                    TD::make('status', 'Stav')->render(fn (SosReport $r) => e($r->status ?? '—')),
                ]),
                'Pomoc' => $this->contentTable('help', 'HelpReport', [
                    TD::make('need', 'Potreba')->render(fn (HelpReport $r) => e($r->need ?? '—')),
                    TD::make('city', 'Mesto')->render(fn (HelpReport $r) => e($r->city ?? '—')),
                    TD::make('description', 'Popis')->render(fn (HelpReport $r) => e(Str::limit((string) $r->description, 60))),
                    TD::make('status', 'Stav')->render(fn (HelpReport $r) => e($r->status ?? '—')),
                ]),
                'Komentáre (Zavoditko)' => $this->contentTable('learnComments', 'LearnComment', [
                    TD::make('topic_id', 'Téma #')->render(fn (LearnComment $c) => (string) $c->topic_id),
                    TD::make('body', 'Komentár')->render(fn (LearnComment $c) => e(Str::limit((string) $c->body, 80))),
                ]),
                'Návrhy miest' => $this->contentTable('placeSuggestions', 'PlaceSuggestion', [
                    TD::make('name', 'Názov')->render(fn (PlaceSuggestion $p) => e($p->name ?? '—')),
                    TD::make('category', 'Kategória')->render(fn (PlaceSuggestion $p) => e($p->category ?? '—')),
                    TD::make('city', 'Mesto')->render(fn (PlaceSuggestion $p) => e($p->city ?? '—')),
                    TD::make('note', 'Poznámka')->render(fn (PlaceSuggestion $p) => e(Str::limit((string) $p->note, 60))),
                ]),
                'Návrhy tém' => $this->contentTable('topicRequests', 'TopicRequest', [
                    TD::make('suggestion', 'Návrh')->render(fn (TopicRequest $t) => e(Str::limit((string) $t->suggestion, 100))),
                ]),
                'Priateľstvá' => $this->contentTable('friendships', 'Friendship', [
                    TD::make('status', 'Stav')->render(fn (Friendship $f) => e($f->status)),
                    TD::make('with', 'S kým')->render(function (Friendship $f) {
                        $other = $f->requester_id === $this->user->id ? $f->addressee : $f->requester;

                        return e($other?->display_name ?? $other?->name ?? '#'.($f->requester_id === $this->user->id ? $f->addressee_id : $f->requester_id));
                    }),
                ]),
                'Fórum — témy' => $this->contentTable('forumTopics', 'ForumTopic', [
                    TD::make('title', 'Názov')->render(fn (ForumTopic $t) => e(Str::limit((string) $t->title, 80))),
                    TD::make('pinned', 'Pripnuté')->render(fn (ForumTopic $t) => $t->pinned ? 'Áno' : 'Nie'),
                ]),
                'Fórum — komentáre' => $this->contentTable('forumComments', 'ForumComment', [
                    TD::make('topic_id', 'Téma #')->render(fn (ForumComment $c) => (string) $c->topic_id),
                    TD::make('body', 'Komentár')->render(fn (ForumComment $c) => e(Str::limit((string) $c->body, 80))),
                ]),
            ])->canSee($this->user->exists),
        ];
    }

    /**
     * Build a content table for a related collection, with a created_at column
     * and a per-row delete button for moderation.
     */
    private function contentTable(string $target, string $model, array $columns)
    {
        $columns[] = TD::make('created_at', 'Vytvorené')
            ->align(TD::ALIGN_RIGHT)
            ->render(fn ($item) => optional($item->created_at)->format('d.m.Y H:i') ?? '—');

        $columns[] = TD::make('Akcie')
            ->align(TD::ALIGN_CENTER)
            ->width('90px')
            ->render(fn ($item) => Button::make(__('Zmazať'))
                ->icon('bs.trash3')
                ->confirm('Naozaj zmazať túto položku používateľa? Akcia je nevratná.')
                ->method('deleteRecord', ['model' => $model, 'id' => $item->id]));

        return Layout::table($target, $columns);
    }

    /**
     * Save account + Nuffy profile fields.
     */
    public function save(User $user, Request $request): RedirectResponse
    {
        $request->validate([
            'user.email' => [
                'required',
                Rule::unique(User::class, 'email')->ignore($user),
            ],
            'user.display_name' => ['nullable', 'string', 'max:60'],
            'user.city' => ['nullable', 'string', 'max:60'],
            'user.gender' => ['nullable', 'in:male,female,unspecified'],
            'user.instagram' => ['nullable', 'string', 'max:60'],
            'user.birth_year' => ['nullable', 'integer', 'min:1900', 'max:'.date('Y')],
            'user.bio' => ['nullable', 'string', 'max:500'],
            'user.avatar_url' => ['nullable', 'string', 'max:2048'],
        ]);

        $permissions = collect($request->get('permissions'))
            ->map(fn ($value, $key) => [base64_decode($key) => $value])
            ->collapse()
            ->toArray();

        $user->when($request->filled('user.password'), function (Builder $builder) use ($request) {
            $builder->getModel()->password = Hash::make($request->input('user.password'));
        });

        $user
            ->fill($request->collect('user')->except(['password', 'permissions', 'roles'])->toArray())
            ->forceFill(['permissions' => $permissions])
            ->save();

        $user->replaceRoles($request->input('user.roles'));

        Toast::info(__('User was saved.'));

        return redirect()->route('platform.systems.users');
    }

    public function remove(User $user): RedirectResponse
    {
        $user->delete();

        Toast::info(__('User was removed'));

        return redirect()->route('platform.systems.users');
    }

    public function loginAs(User $user): RedirectResponse
    {
        Impersonation::loginAs($user);

        Toast::info(__('You are now impersonating this user'));

        return redirect()->route(config('platform.index'));
    }

    /**
     * Delete a single moderatable record created by the user.
     */
    public function deleteRecord(Request $request): void
    {
        $class = self::MODERATABLE[$request->get('model')] ?? null;
        abort_unless($class, 404);

        $class::findOrFail($request->get('id'))->delete();

        Toast::info('Položka bola zmazaná.');
    }
}
