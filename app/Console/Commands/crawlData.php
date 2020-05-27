<?php

namespace App\Console\Commands;

use App\Observers\PageCrawlObserver;
use Illuminate\Console\Command;

use Spatie\Crawler\Crawler;

class crawlData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawlData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $siteUrl= 'http://truyentranhtuan.com/';
        $data = Crawler::create()
            ->setCrawlObserver(new PageCrawlObserver())
            ->startCrawling($siteUrl);
        echo 'Crawl Done !';
    }
}
