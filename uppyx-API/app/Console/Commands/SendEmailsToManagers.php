<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmailsToManagers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uppyx:send-emails-to-managers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command send emails to managers to remind them to assign the planned requests';

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
     * @return mixed
     */
    public function handle()
    {
        $response = app('App\Http\Controllers\RentalRequestController')->emailPlannedRequest();
        $responseContent = json_decode($response->getContent());
        $this->info($responseContent->message);
    }
}
