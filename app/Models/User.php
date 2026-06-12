<?php

namespace App\Models;

use App\Mail\ResetPasswordMail;
use App\Mail\VerifyEmailMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'display_name',
        'city',
        'avatar_url',
        'gender',
        'with_dog_photos',
        'bio',
        'birth_year',
        'notification_prefs',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'             => 'array',
        'email_verified_at'       => 'datetime',
        'with_dog_photos'         => 'array',
        'birth_year'              => 'integer',
        'notification_prefs'      => 'array',
        'two_factor_secret'       => 'encrypted',
        'two_factor_confirmed_at' => 'datetime',
    ];

    /**
     * Whether the user wants a given e-mail notification.
     * Defaults to true when the preference has not been set.
     *
     * Keys: friend_requests, friend_accepted, sos, videos
     */
    public function wantsNotification(string $key): bool
    {
        return (bool) ($this->notification_prefs[$key] ?? true);
    }

    /**
     * Send the e-mail verification notification using the Nuffy-branded mail.
     */
    public function sendEmailVerificationNotification(): void
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes((int) Config::get('auth.verification.expire', 1440)),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())],
        );

        Mail::to($this->email)->send(new VerifyEmailMail($url));
    }

    /**
     * Send the password reset notification using the Nuffy-branded mail.
     */
    public function sendPasswordResetNotification($token): void
    {
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ], false));

        Mail::to($this->email)->send(new ResetPasswordMail($url));
    }

    public function hasTwoFactorEnabled(): bool
    {
        return ! is_null($this->two_factor_confirmed_at);
    }

    public function dogs()
    {
        return $this->hasMany(Dog::class, 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function friendshipsAsRequester()
    {
        return $this->hasMany(Friendship::class, 'requester_id');
    }

    public function friendshipsAsAddressee()
    {
        return $this->hasMany(Friendship::class, 'addressee_id');
    }

    public function appRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function hasAppRole(string $role): bool
    {
        return $this->appRoles()->where('role', $role)->exists();
    }

    public function isAdmin(): bool
    {
        return $this->hasAppRole('admin') || $this->hasAccess('platform.index');
    }

    public function isFriendWith(User $other): bool
    {
        return Friendship::where('status', 'accepted')
            ->where(function ($q) use ($other) {
                $q->where(['requester_id' => $this->id, 'addressee_id' => $other->id])
                  ->orWhere(['requester_id' => $other->id, 'addressee_id' => $this->id]);
            })
            ->exists();
    }

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
           'id'         => Where::class,
           'name'       => Like::class,
           'email'      => Like::class,
           'updated_at' => WhereDateStartEnd::class,
           'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];
}
