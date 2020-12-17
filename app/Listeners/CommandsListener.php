<?php

namespace App\Listeners;

use App\Models\Scheduler;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Carbon;

class CommandsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommandFinished  $event
     * @return void
     */
    public function handle(CommandFinished $event)
    {
        if ($event->command == 'update:db' || $event->command == 'generate:sitemap') {

            $options = '';
            if ($event->input->hasOption('lastest')) {
                $options = $event->input->getOption('lastest') ? '--lastest' : '';
            }
            Scheduler::updateOrCreate(
                [
                    'task' => $event->command.' '.$options
                ],
                [
                    'updated_at' => Carbon::now('UTC')->setTimezone('Europe/Paris')
                ]
            );
        }
    }
}
