<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Jobs\SendEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendEmailEvent $event): void
    {
        // Dispatch the job to send email
        SendEmailJob::dispatch($event->user, $event->account, $event->tempPassword,$event->otp);
    }
}
