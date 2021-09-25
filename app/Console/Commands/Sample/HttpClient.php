<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;

class HttpClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:HttpClient';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル HTTPクライアント';

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
        "guzzlehttp/guzzle": "6.5.*"

        */


        $client = new \GuzzleHttp\Client();


        $url = 'https://holidays-jp.github.io/api/v1/date.json';

        $options = [];
        $options['headers'] = ['User-Agent' => 'UserAgent1.0'];

        try {

            $response = $client->get($url, $options);

            $contents = $response->getBody()->getContents();

            print $contents . PHP_EOL;
        } catch (\GuzzleHttp\Exception\RequestException $e) {

            print $e->getMessage() . PHP_EOL;

            if ($e->hasResponse()) {

                $e->getResponse()->getStatusCode();

                $e->getResponse()->getBody()->getContents();
            }

            throw $e;
        }
    }
}
