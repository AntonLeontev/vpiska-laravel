<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BaseRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpiska:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh migrations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (app()->isProduction()) {
            echo ('Сдурел? Это же прод!' . PHP_EOL);
            return Command::FAILURE;
        }

        Storage::deleteDirectory('images/user_photos');
        Storage::deleteDirectory('images/event_photos');

        $this->call('migrate:fresh', ['--seed' => true]);

        return Command::SUCCESS;
    }
}
