<?php

namespace App\Console\Commands\Sample;

use Illuminate\Console\Command;
use App\Models\Article;

class Factory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:Factory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプル テストデータ作成';

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

        for ($i = 0; $i < 30; $i++) {

            $faker = \Faker\Factory::create('ja_JP');

            $article = new Article();

            $article->title = $faker->sentence;
            $article->description = $faker->paragraph;

            $path = $faker->image('public/uploads/images', 640, 360);
            $article->image = 'uploads/images/' . basename($path);

            $article->published_at = now()->subDays(rand(1, 30));

            $article->active = true;

            $article->save();
        }
    }
}
