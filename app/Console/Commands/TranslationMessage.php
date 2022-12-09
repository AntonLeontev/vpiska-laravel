<?php

namespace App\Console\Commands;

use App\Events\TranslationEvent;
use Illuminate\Console\Command;

class TranslationMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpiska:message {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fire event';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        event(new TranslationEvent(
            $this->argument('message')
        ));
        echo "Event fired\n";
        return Command::SUCCESS;
    }
}
