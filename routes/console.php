<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Denne zmaž SOS inzeráty staršie ako 30 dní (GDPR + upratovanie).
Schedule::command('nuffy:prune-listings')->dailyAt('03:00');
