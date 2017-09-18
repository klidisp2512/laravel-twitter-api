<?php

namespace App\Http\Controllers;

use App\Services\TweetsService;
use App\Http\Requests\TweetsRequest;

class TweetsController extends Controller
{
    /**
     * TweetsService class instance injected through construct
     *
     * @var object
     */
	private $tweetsService;

    public function __construct(TweetsService $tweetsService)
    {
        $this->tweetsService = $tweetsService;
    }

    /**
     * Display initial form and display result for resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index() 
	{
		return view('index');
	}

	public function getTweetData(TweetsRequest $request) 
	{
		$tweet = $this->tweetsService->getTweetData($request->tweet_url);

		return view('index', compact('tweet'));  
	}

}	