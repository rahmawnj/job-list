<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Visitor;

class ClearOldVisitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:old-visitors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $deletedRows = Visitor::where('created_at', '<', $oneMonthAgo)->delete();
        $this->info("Old visitors have been cleared successfully. Deleted rows: $deletedRows");
    }
}
