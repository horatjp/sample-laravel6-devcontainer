<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use File, PDF;


class PdfProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:PdfProcessing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル PDF';

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

        /*
         "barryvdh/laravel-dompdf":"0.8.*",

        curl -o ./vendor/dompdf/dompdf/load_font.php https://raw.githubusercontent.com/dompdf/utils/master/load_font.php
        cp -r ./vendor/phenx/* ./vendor/dompdf/dompdf/lib/
        php ./vendor/dompdf/dompdf/load_font.php ipag ./resources/font/ipag.ttf
        cp -r ./vendor/dompdf/dompdf/lib/fonts ./storage
        */

        if (!File::exists(storage_path('sample'))) {
            File::makeDirectory(storage_path('sample'), 493, true);
        }

        $file = storage_path('sample') . '/sample.pdf';


        $html = '<!doctype html>
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Create PDF</title>
        <style>
        body {
        font-family: ipag;
        }
        </style>
        </head>
        <body>
        <h1>テスト</h1>
        </body>
        </html>
        ';


        $pdf = PDF::loadHTML($html);

        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isFontSubsettingEnabled' => true]);
        $pdf->save($file);
    }
}
