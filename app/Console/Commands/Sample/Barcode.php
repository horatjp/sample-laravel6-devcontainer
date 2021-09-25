<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use File, DNS1D, DNS2D;

class Barcode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:Barcode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル バーコード';

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


        File::put(storage_path('sample') . '/EAN8.svg', DNS1D::getBarcodeSVG('1000', 'EAN8'));

        File::put(storage_path('sample') . '/QRCODE.svg', DNS2D::getBarcodeSVG('1000', 'QRCODE'));


        File::put(storage_path('sample') . '/EAN8.png', base64_decode(DNS1D::getBarcodePNG('1000', 'EAN8')));

        File::put(storage_path('sample') . '/QRCODE.png', base64_decode(DNS2D::getBarcodePNG('1000', 'QRCODE')));
    }
}
