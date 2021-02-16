<?php

namespace Botble\BlogCrawler\Commands;

use Illuminate\Console\Command;

class RunCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:crawler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command crawler posts';

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
     * @return mix
     */
    public function handle()
    {
        $this->call('cms:post-crawler');
        $this->call('cms:post-crawler');
        $this->call('cms:post-crawler');
        $this->call('cms:post-crawler');
        $this->call('cms:post-crawler');
        $this->call('cms:post-crawler');
        $this->call('cms:post-crawler');
    }

}
