<?php

namespace App\Console\Commands;

use App\Actions\DispatchActions;
use Illuminate\Console\Command;

class SendDispatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch send messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DispatchActions::sendNear();
    }
}
