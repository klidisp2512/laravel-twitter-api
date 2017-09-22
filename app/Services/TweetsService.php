<?php

namespace  App\Services;

use Twitter;
use App\Tweet;

class TweetsService 
{

    /**
     * Fetches tweet data from twiter api, calculates, persists and returns the created record
     * 
     * @param  $tweetUrl | string
     * @return $tweet | object
     */	
    public function getTweetData($tweetUrl) 
    {
        $tweetId = $this->parseIdFromTweetUrl($tweetUrl);

        $tweet = Tweet::findTweet($tweetId);
        if ($tweet) {
	    $tweetData = $this->getTweetDataFromApi($tweetId);
            $attributes = $this->prepareAttributes($tweetData);
            
	    return Tweet::create($attributes);
        } 
        return $tweet;
    }

    /**
     * Fetch tweets collection, updates tweet data using the api and then updates the tweet model.
     * 
     * @param  none
     * @return void
     */
    public function updateTweetsData() 
    {
        $tweets = Tweet::all();
        if ($tweets->count()) {
            foreach ($tweets as $tweet) {
                $tweetData  = $this->getTweetDataFromApi($tweet->tweet_id);
                $attributes = $this->prepareAttributes($tweetData);
                $tweet->update($attributes);
           }
        }	
    }

    /**
     * Parses tweet Url and returns tweet id
     *
     * @param  $tweetUrl | string
     * @return tweet id | int
     */
    private function parseIdFromTweetUrl($tweetUrl)
    {
        $path = parse_url($tweetUrl)['path']; 
        return explode('/', $path)[3];
    }

     /**
      * Fetch max of 100 most recent retweets of tweet from twitter api
      *
      * @param  $tweetId | int
      * @return $tweed data | array
      */
     private function getTweetDataFromApi($tweetId) 
     {
         $retweets = Twitter::getRts($tweetId, [ 'count' => 100]);

         $reach = $this->countReach($retweets);

         return [
             'tweet' => $retweets[0]->retweeted_status,
             'reach' => $reach,
             'retweets_count' => count($retweets)
         ];
     }

    /**
     * Calculate total reach by counting user followers
     *
     * @param  $retweets | array
     * @return $reachCount | int
     */
    private function countReach($retweets) {
        $reachCount = 0;

        $originUserFollowers = $retweets[0]->retweeted_status->user->followers_count;
        $reachCount += $originUserFollowers; 

        foreach ($retweets as $retweet) {
            if (!empty($retweet->user)) {
  	        $reachCount += $retweet->user->followers_count;
	    }
        }

        return $reachCount;
    }

    /**
     * Prepare attributes for creating new tweet record
     *
     * @return Attributes | array
     */
    private function prepareAttributes($tweetData)
    {
        return [
            'tweet_id' => $tweetData['tweet']->id,
            'total_retweets'   =>  $tweetData['tweet']->retweet_count,
            'counted_retweets' =>  $tweetData['retweets_count'],
            'reach' => $tweetData['reach']
        ];
    }

}

