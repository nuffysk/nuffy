<?php

namespace App\Observers;

use App\Mail\SectionActivityMail;
use App\Models\LearnTopic;
use App\Models\User;
use App\Support\NotifyUsers;
use App\Support\Unsubscribe;

class LearnTopicObserver
{
    /**
     * A new learn topic was created — if it carries a video, treat it as a new
     * "Závoditko" video and notify subscribed users.
     */
    public function created(LearnTopic $topic): void
    {
        if (empty($topic->video_url)) {
            return;
        }

        NotifyUsers::broadcast(
            'videos',
            fn (User $u) => new SectionActivityMail(
                'video',
                'Závoditko',
                route('learn.show', $topic->slug),
                Unsubscribe::url($u->id, 'videos'),
            ),
        );
    }
}
