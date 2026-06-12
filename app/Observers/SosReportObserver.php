<?php

namespace App\Observers;

use App\Mail\SectionActivityMail;
use App\Models\SosReport;
use App\Support\NotifyUsers;

class SosReportObserver
{
    /**
     * A new SOS report was published — notify subscribed users.
     */
    public function created(SosReport $report): void
    {
        NotifyUsers::broadcast(
            'sos',
            new SectionActivityMail('post', 'SOS linka', route('sos.index')),
            excludeId: $report->reporter_id,
        );
    }
}
