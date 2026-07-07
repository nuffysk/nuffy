<?php

namespace Tests\Feature;

use App\Models\Dog;
use App\Models\ForumComment;
use App\Models\ForumReport;
use App\Models\ForumTopic;
use App\Models\Friendship;
use App\Models\HelpReport;
use App\Models\LearnComment;
use App\Models\LearnTopic;
use App\Models\Novinka;
use App\Models\Place;
use App\Models\PlaceSuggestion;
use App\Models\Post;
use App\Models\SosReport;
use App\Models\TopicRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route as RouteInstance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

/**
 * Walks every GET route of the app as guest, regular user and admin,
 * failing on any 5xx (and on 404 for routes whose parameters we seeded).
 * Serves as a whole-site regression net.
 */
class SiteSmokeTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $other;
    private User $admin;
    private Dog $dog;
    private LearnTopic $learnTopic;
    private ForumTopic $forumTopic;
    private Novinka $novinka;
    private Place $place;
    private SosReport $sos;
    private Friendship $friendship;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable the beta gate for tests.
        config(['platform.gate_password' => null]);

        $this->user = User::create([
            'name' => 'Test User', 'email' => 'user@test.sk',
            'password' => Hash::make('password'), 'birth_year' => 1990,
        ]);
        $this->user->forceFill(['email_verified_at' => now()])->save();

        $this->other = User::create([
            'name' => 'Other User', 'email' => 'other@test.sk',
            'password' => Hash::make('password'), 'birth_year' => 1992,
        ]);
        $this->other->forceFill(['email_verified_at' => now()])->save();

        $this->admin = User::create([
            'name' => 'Admin', 'email' => 'admin@test.sk',
            'password' => Hash::make('password'), 'birth_year' => 1985,
        ]);
        $this->admin->forceFill([
            'email_verified_at' => now(),
            'permissions' => [
                'platform.index' => true,
                'platform.content' => true,
                'platform.systems.users' => true,
                'platform.systems.roles' => true,
                'platform.systems.attachment' => true,
            ],
        ])->save();

        $this->dog = Dog::create(['owner_id' => $this->user->id, 'name' => 'Rex', 'gender' => 'male']);
        $this->learnTopic = LearnTopic::create(['slug' => 'testovacia-tema', 'title' => 'Testovacia téma', 'sort_order' => 1]);
        $this->forumTopic = ForumTopic::create(['title' => 'Fórum téma', 'body' => 'Obsah témy', 'author_id' => $this->user->id]);
        ForumComment::create(['topic_id' => $this->forumTopic->id, 'author_id' => $this->other->id, 'body' => 'Komentár']);
        $this->novinka = Novinka::create(['slug' => 'testovacia-novinka', 'title' => 'Novinka', 'content' => 'Obsah', 'author_id' => $this->admin->id]);
        $this->place = Place::create(['name' => 'Psí hotel', 'category' => 'hotel', 'city' => 'Bratislava']);
        $this->sos = SosReport::create(['reporter_id' => $this->user->id, 'description' => 'Nájdený pes', 'kind' => 'found', 'status' => 'open', 'city' => 'Nitra']);
        $this->friendship = Friendship::create(['requester_id' => $this->other->id, 'addressee_id' => $this->user->id, 'status' => 'pending']);
        LearnComment::create(['topic_id' => $this->learnTopic->id, 'author_id' => $this->user->id, 'body' => 'Learn komentár']);
        HelpReport::create(['reporter_id' => $this->user->id, 'description' => 'Potrebuje pomoc', 'need' => 'domov', 'status' => 'open']);
        PlaceSuggestion::create(['user_id' => $this->user->id, 'category' => 'hotel', 'name' => 'Návrh miesta']);
        TopicRequest::create(['user_id' => $this->user->id, 'suggestion' => 'Nová téma prosím']);
        Post::create(['author_id' => $this->user->id, 'dog_id' => $this->dog->id, 'image_url' => '/storage/test.jpg', 'caption' => 'Prvý post']);
        ForumReport::create(['reporter_id' => $this->other->id, 'target_type' => 'topic', 'target_id' => $this->forumTopic->id, 'reason' => 'spam', 'status' => 'open']);
    }

    /** Fill a route's parameters from seeded models; null = cannot fill → skip. */
    private function urlFor(RouteInstance $route): ?string
    {
        $params = [];
        foreach ($route->parameterNames() as $name) {
            $uri = $route->uri();
            $value = match ($name) {
                'user' => $this->other->id,
                'dog' => $this->dog->id,
                'friendship' => $this->friendship->id,
                'novinka' => str_starts_with($uri, 'admin') ? $this->novinka->id : $this->novinka->slug,
                'place' => $this->place->id,
                'report' => $this->sos->id,
                'topic' => str_starts_with($uri, 'learn')
                    ? $this->learnTopic->slug
                    : (str_starts_with($uri, 'admin') ? $this->learnTopic->id : $this->forumTopic->id),
                'method' => null, // Orchid optional {method?} — leave empty
                default => null,
            };
            if ($value === null && ! str_contains($uri, '{'.$name.'?}')) {
                return null; // required param we can't fill
            }
            if ($value !== null) {
                $params[$name] = $value;
            }
        }

        try {
            return route($route->getName() ?: '', $params, false) ?: null;
        } catch (\Throwable) {
            return null; // un-generatable route (e.g. Orchid fallback) — skip
        }
    }

    /** GET routes worth walking (named, no signed/token routes). */
    private function walkableRoutes(): array
    {
        $skip = [
            'verification.verify',        // signed
            'password.reset',             // token
            'settings.export.download',   // signed — tested explicitly
            'settings.account.delete.confirm', // signed — tested explicitly
            'notifications.unsubscribe',  // signed — tested explicitly
            'auth.google.redirect',       // external redirect (no creds in tests)
            'auth.google.callback',
        ];

        $routes = [];
        foreach (Route::getRoutes() as $route) {
            if (! in_array('GET', $route->methods(), true)) {
                continue;
            }
            $name = $route->getName();
            if (! $name || in_array($name, $skip, true)) {
                continue;
            }
            if (($url = $this->urlFor($route)) !== null) {
                $routes[$name] = $url;
            }
        }

        return $routes;
    }

    private function walkAs(?User $actor, array $mustBeOk = []): void
    {
        if ($actor) {
            $this->actingAs($actor);
        }

        $failures = [];
        foreach ($this->walkableRoutes() as $name => $url) {
            $status = $this->get($url)->getStatusCode();

            if ($status >= 500) {
                $failures[] = "[$status] $name → $url";
            } elseif (in_array($name, $mustBeOk, true) && $status !== 200) {
                $failures[] = "[$status, expected 200] $name → $url";
            }
        }

        $this->assertSame([], $failures, "Route failures:\n".implode("\n", $failures));
    }

    public function test_guest_can_walk_site_without_errors(): void
    {
        $this->walkAs(null, mustBeOk: [
            'home', 'login', 'register', 'password.request', 'privacy', 'terms',
            'cookies', 'support', 'novinky.index', 'novinky.show', 'learn.index',
            'learn.show', 'places.index', 'places.show', 'walks.index', 'walks.show',
            'sos.index', 'sos.help', 'search',
        ]);
    }

    public function test_user_can_walk_site_without_errors(): void
    {
        $this->walkAs($this->user, mustBeOk: [
            'home', 'profile.show', 'profile.edit', 'dog.create', 'dog.edit',
            'friends.index', 'settings', 'settings.account', 'settings.email',
            'settings.password', 'settings.notifications', 'settings.blocked',
            'settings.two-factor', 'users.show', 'sos.index', 'learn.show',
            'walks.show', 'novinky.show',
        ]);
    }

    public function test_admin_can_walk_admin_without_errors(): void
    {
        $mustBeOk = [
            'platform.main', 'platform.profile', 'platform.systems.users',
            'platform.systems.users.edit', 'platform.systems.roles',
            'platform.deletion-logs', 'platform.content-reports', 'platform.sos',
            'platform.help-reports', 'platform.place-suggestions',
            'platform.topic-requests', 'platform.forum',
        ];
        // Only assert-200 the ones that exist (menu can evolve).
        $existing = array_filter($mustBeOk, fn ($n) => Route::has($n));

        $this->walkAs($this->admin, mustBeOk: $existing);
    }

    public function test_signed_links_work(): void
    {
        $this->actingAs($this->user);

        // GDPR export download (24h signed)
        $url = URL::temporarySignedRoute('settings.export.download', now()->addHours(24), ['user' => $this->user->id]);
        $this->get($url)->assertOk();

        // Account-deletion confirm page (signed, no side effects on GET)
        $url = URL::temporarySignedRoute('settings.account.delete.confirm', now()->addHours(24), ['user' => $this->user->id]);
        $this->get($url)->assertOk();

        // One-click unsubscribe
        $url = URL::signedRoute('notifications.unsubscribe', ['user' => $this->user->id, 'pref' => 'sos']);
        $this->get($url)->assertOk();
        $this->assertFalse($this->user->fresh()->wantsNotification('sos'));

        // Tampered signature must fail
        $this->get(route('notifications.unsubscribe', ['user' => $this->user->id, 'pref' => 'sos']).'?signature=bad')
            ->assertForbidden();
    }
}
