<?php

namespace App\Console\Commands;

use App\Actions\ArchiveOldEventsAction;
use Illuminate\Console\Command;

class ArchiveOldEventsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archives finished events';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ArchiveOldEventsAction $action)
    {
        $action->handle();
        return Command::SUCCESS;
    }
}
