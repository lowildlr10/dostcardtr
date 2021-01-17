<?php

namespace App\Console\Commands;

use App\Services\BioSyncService;
use Illuminate\Console\Command;

class SyncBiometrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    private $bioSyncService;
    protected $signature = 'biometrics:sync {synctype} {--userid=} {--datefrom=} {--dateto=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync biometrics data from Anviz P7 MS SQL.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BioSyncService $bioSyncService)
    {
        parent::__construct();
        $this->bioSyncService = $bioSyncService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('synctype');
        $userID = $this->option('userid');
        $dateFrom = $this->option('datefrom');
        $dateTo = $this->option('dateto');

        $bioMsg = $this->bioSyncService->init($type, $userID, $dateFrom, $dateTo);

        $this->info($bioMsg);
    }
}
