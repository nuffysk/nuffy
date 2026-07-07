<?php

namespace Tests\Feature;

use App\Mail\AccountDeletionRequestMail;
use App\Mail\VerifyEmailMail;
use App\Models\DeletionLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/profile')->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/profile', [
            'display_name' => 'Psíčkar Peter',
            'gender' => 'male',
            'city' => 'Bratislava',
            'bio' => 'Milujem psy.',
            'instagram' => 'psickar_peter',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');

        $user->refresh();
        $this->assertSame('Psíčkar Peter', $user->display_name);
        $this->assertSame('Bratislava', $user->city);
        $this->assertSame('psickar_peter', $user->instagram);
    }

    public function test_email_can_be_changed_and_requires_reverification(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/settings/email', [
            'email' => 'nova@adresa.sk',
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        $user->refresh();
        $this->assertSame('nova@adresa.sk', $user->email);
        $this->assertNull($user->email_verified_at);
        Mail::assertQueued(VerifyEmailMail::class);
    }

    public function test_account_deletion_requires_email_confirmation(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        // Step 1: request deletion — account must NOT be deleted yet.
        $response = $this->actingAs($user)->delete('/settings/account', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertNotNull($user->fresh());
        Mail::assertQueued(AccountDeletionRequestMail::class);

        // Step 2: confirm via signed link — account is deleted + logged.
        $url = URL::temporarySignedRoute('settings.account.delete.perform', now()->addHours(24), ['user' => $user->id]);
        $this->post($url)->assertRedirect(route('home'));

        $this->assertNull($user->fresh());
        $this->assertDatabaseHas('deletion_logs', ['user_id' => $user->id]);
    }

    public function test_correct_password_must_be_provided_to_request_deletion(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/settings/account')
            ->delete('/settings/account', ['password' => 'wrong-password']);

        $response->assertSessionHasErrors('password')->assertRedirect('/settings/account');
        $this->assertNotNull($user->fresh());
        Mail::assertNothingQueued();
    }
}
