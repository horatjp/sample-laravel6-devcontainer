<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use File;

class Csv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:Csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル CSV';

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
        "league/csv": "9.2.*",

        */


        $file = storage_path('sample') . '/sample.csv';

        file_put_contents($file, null);

        // 書き込み
        $csv = \League\Csv\Writer::createFromPath($file);

        $converter = (new \League\Csv\CharsetConverter())->inputEncoding('UTF-8')->outputEncoding('SJIS-win');
        $csv->addFormatter($converter);

        $csv->setDelimiter(",");
        $csv->setEnclosure('"');
        $csv->setNewline("\r\n");

        $header = ['first name', 'last name', 'email'];

        $records = [
            [1, 2, 3],
            ['foo', 'bar', 'baz'],
            ['john', 'doe', 'john.doe@example.com'],
            ['次郎', '山本', 'test@test.com'],
        ];

        $csv->insertOne($header);

        $csv->insertAll($records);


        // 読み込み
        $csv = \League\Csv\Reader::createFromPath($file);

        \League\Csv\CharsetConverter::addTo($csv, 'SJIS-win', 'UTF-8');

        $csv->setHeaderOffset(0);

        $header = $csv->getHeader();

        print_r($header);

        foreach ($csv as $data) {

            print_r($data);
        }



        // 文字コード変換後読み込み
        $tmpfile = tmpfile();
        fwrite($tmpfile, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));
        rewind($tmpfile);
        $tmpfileMeta = stream_get_meta_data($tmpfile);

        // CSV読み込み
        $csv = \League\Csv\Reader::createFromFileObject(new \SplFileObject($tmpfileMeta['uri']));
    }
}
