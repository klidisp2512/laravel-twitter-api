<?php

namespace App\Console\Commands;

use App\Services\TweetsService;
use Illuminate\Console\Command;

class UpdateTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweets:update';

    protected $tweetService;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates persisted tweets data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TweetsService $tweetsService)
    {
        parent::__construct();

        $this->tweetsService = $tweetsService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->tweetsService->updateTweetsData();
    }
}
