<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use File, Storage;

class FTP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:FTP';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル FTP';

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

        $file = storage_path('sample') . '/ftp.data';

        file_put_contents($file, 'ftpdata');


        $connectionKey = 'ftp';

        config(['filesystems.disks.' . $connectionKey => [
            'driver'    => 'ftp',
            'host'      => 'host',
            'username'  => 'username',
            'password'  => 'password',
        ]]);


        $filename = basename($file);

        if (!Storage::disk($connectionKey)->has($filename)) {

            Storage::disk($connectionKey)->put($filename, File::get($file));
        }
    }
}
