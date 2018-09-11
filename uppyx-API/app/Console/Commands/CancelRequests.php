<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CancelRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uppyx:cancel-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command cancels all requests after 2 minutes of it\'s creation';

    /**
     * CancelRequests constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = app('App\Http\Controllers\RentalRequestController')->cancelRequest();
        $responseContent = json_decode($response->getContent());
        $this->info($responseContent->message);
    }
}
