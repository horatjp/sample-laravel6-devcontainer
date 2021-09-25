<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;

class Scraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:Scraper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル スクレイピング';

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
        "fabpot/goutte": "3.2.*",
        */

        $url = 'https://yahoo.co.jp/';

        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36';

        $client = new \Goutte\Client(['HTTP_USER_AGENT' => $userAgent]);

        $cookies = $client->getCookieJar()->all();

        $client->getCookieJar()->updateFromSetCookie($cookies);

        $response = $client->request('GET', $url);

        if (count($response->filter('#tabpanelTopics1 h1'))) {

            $response->filter('#tabpanelTopics1 h1')->each(function ($node) {

                print $node->text() . PHP_EOL;
            });
        }
    }
}
