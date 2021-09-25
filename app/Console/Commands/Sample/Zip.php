<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use File;

class Zip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:Zip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル ZIP';

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

        $file = storage_path('sample') . '/sample.zip';

        $zip = new \ZipArchive();

        $zip->open($file, \ZipArchive::CREATE);

        for ($i = 0; $i < 10; $i++) {

            $f = storage_path('sample') . '/' . $i;

            File::put($f, $i);

            $zip->addFile($f, basename($f));
        }

        $zip->close();
    }
}
