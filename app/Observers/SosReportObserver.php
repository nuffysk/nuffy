<?php

namespace App\Observers;

use App\Mail\SectionActivityMail;
use App\Models\SosReport;
use App\Models\User;
use App\Support\NotifyUsers;
use App\Support\Unsubscribe;

class SosReportObserver
{
    /**
     * A new SOS report was published — notify subscribed users.
     */
    public function created(SosReport $report): void
    {
        NotifyUsers::broadcast(
            'sos',
            fn (User $u) => new SectionActivityMail(
                'post',
                'SOS linka',
                route('sos.index'),
                Unsubscribe::url($u->id, 'sos'),
            ),
            excludeId: $report->reporter_id,
        );
    }
}
