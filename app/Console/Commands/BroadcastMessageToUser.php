<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\TestBroadcastNotification;
use Illuminate\Console\Command;

class BroadcastMessageToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpiska:testBroadcast {user_id} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send broadcast message to user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('user_id'));

        if (is_null($user)) {
            print "Нет пользователя с таким ID";
            return Command::FAILURE;
        }

        $user->notify(new TestBroadcastNotification($this->argument('message')));
        return Command::SUCCESS;
    }
}
