<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Report;
use App\Items;
class ReportItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ReportItem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        return Items::where('report_status' >= 10)->update(['is_reported' => 1]);
      
    }
}
