<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class ExcelOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:ExcelOperation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル エクセル';

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
        "phpoffice/phpspreadsheet": "1.10.*",

        */

        $file = storage_path('sample') . '/sample.xlsx';


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save($file);




        $reader = new XlsxReader();

        $spreadsheet = $reader->load($file);

        $sheet = $spreadsheet->getActiveSheet();

        $cellValue = $sheet->getCell("A1")->getCalculatedValue();

        print $cellValue . PHP_EOL;
    }


    private function excelFormatting(&$excel, $column, $format = \PHPExcel_Cell_DataType::TYPE_STRING)
    {

        $data = $excel->getActiveSheet()->toArray();

        if (count($data) > 1) {

            for ($i = 1; $i < count($data); $i++) {

                $excel->getActiveSheet()->getCellByColumnAndRow($column, $i + 1)->setValueExplicit($data[$i][$column], $format);
            }
        }
    }
}
