<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tweet_id', 'total_retweets', 'counted_retweets', 'reach'
    ];

    public function scopeFindTweet($query, $tweetId)
    {
        return $query->where('tweet_id', '=', $tweetId);
    }

}
