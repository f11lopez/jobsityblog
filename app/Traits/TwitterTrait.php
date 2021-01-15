<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;


trait TwitterTrait {
  
  protected $endpoint_user = 'https://api.twitter.com/2/users/by/username/{{username}}?tweet.fields=id';
  protected $endpoint_timeline = 'https://api.twitter.com/2/users/{{userid}}/tweets?max_results=5&tweet.fields=id,created_at,text';
  protected $endpoint_tweet = 'https://api.twitter.com/2/tweets/{{tweetid}}?tweet.fields=created_at,id,text&expansions=author_id&user.fields=profile_image_url,url,username';
  
  /**
   * Get Id of a given username, false if it does not exist
   *
   * @return array or false
  */
  public function getTwitterUserIDByUsername($twitterUserName)
  {
    $endpoint_request = str_replace('{{username}}',$twitterUserName,$this->endpoint_user);
    $aResponse = Http::withToken(env('TWITTER_BEARER_TOKEN', false))->get($endpoint_request)->json();
    //success
    if (isset($aResponse['data']['id'])) {
      return $aResponse['data']['id'];
    }
    //failure
    else {
      return false;
    }
  }
  
  /**
   * Get timeline of a given userid, false if it errors
   *
   * @return array or false
  */
  public function getTwitterTimelineByUserID($twitterUserID)
  {
    $endpoint_request = str_replace('{{userid}}',$twitterUserID,$this->endpoint_timeline);
    $aResponse = Http::withToken(env('TWITTER_BEARER_TOKEN', false))->get($endpoint_request)->json();
    //success
    if (isset($aResponse['data'])) {
      return $aResponse['data'];
    }
    //failure
    else {
      return false;
    }
  }
  
  /**
   * Get timeline of a given userid, false if it errors
   *
   * @return array or false
  */
  public function getTweetByID($tweetID)
  {
    $endpoint_request = str_replace('{{tweetid}}',$tweetID,$this->endpoint_tweet);
    $aResponse = Http::withToken(env('TWITTER_BEARER_TOKEN', false))->get($endpoint_request)->json();
    //success
    if (isset($aResponse['data'])) {
      if ($aResponse['includes']['users'][0]) {
        $aResponse['data']['user'] = $aResponse['includes']['users'][0];
      }
      return $aResponse['data'];
    }
    //failure
    else {
      return false;
    }
  }  
  
} //trait