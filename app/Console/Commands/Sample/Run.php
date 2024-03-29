<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use File, DB;

class Run extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル 実行';

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
        print 'RUN' . PHP_EOL;
    }
}
