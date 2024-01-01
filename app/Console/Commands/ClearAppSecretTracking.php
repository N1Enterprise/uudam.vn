<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAppSecretTracking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app-secret-tracking:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear App Secret Tracking';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger('clear telescope');
        return 0;
    }
}
