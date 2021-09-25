<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use Image, File;

class ImageProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:ImageProcessing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル 画像処理';

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
        "intervention/image": "2.*",

        */


        $image = Image::make(public_path('images/logo.png'));

        $image->text('あいうえお', 10, 20, function ($font) {

            $font->file(resource_path('font/ipag.ttf'));
            $font->size(56);
            $font->color('#666');
            //$font->align('center');
            $font->valign('top');
            //$font->angle(45);
        });

        $image->resize(600, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save(storage_path('sample') . '/' . 'sample.jpg');
    }
}
