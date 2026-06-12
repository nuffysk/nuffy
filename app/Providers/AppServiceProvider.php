<?php

namespace App\Providers;

use App\Models\Friendship;
use App\Models\LearnTopic;
use App\Models\SosReport;
use App\Observers\FriendshipObserver;
use App\Observers\LearnTopicObserver;
use App\Observers\SosReportObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Friendship::observe(FriendshipObserver::class);
        SosReport::observe(SosReportObserver::class);
        LearnTopic::observe(LearnTopicObserver::class);
    }
}
