<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChargePlannedRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uppyx:charge-planned-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command pre-charge all planned requests before 1 day of it\'s pickup_date';

    /**
     * ChargePlannedRequests constructor.
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
        $response = app('App\Http\Controllers\RentalRequestController')->chargePlannedRequest();
        $responseContent = json_decode($response->getContent());
        $this->info($responseContent->message);
    }
}
