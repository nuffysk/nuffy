<?php

namespace App\Console\Commands;

use App\Models\SosReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PruneListings extends Command
{
    protected $signature = 'nuffy:prune-listings {--days=30 : Vek inzerátu v dňoch, po ktorom sa maže}';

    protected $description = 'Zmaže SOS inzeráty staršie ako N dní (predvolene 30) vrátane ich fotiek.';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $cutoff = now()->subDays($days);

        $count = 0;

        SosReport::where('created_at', '<', $cutoff)
            ->chunkById(200, function ($reports) use (&$count) {
                foreach ($reports as $report) {
                    // Remove the uploaded photo from public storage, if any.
                    if ($report->photo_url && str_starts_with($report->photo_url, '/storage/')) {
                        Storage::disk('public')->delete(substr($report->photo_url, strlen('/storage/')));
                    }
                    $report->delete();
                    $count++;
                }
            });

        $this->info("Zmazaných inzerátov starších ako {$days} dní: {$count}.");

        return self::SUCCESS;
    }
}
