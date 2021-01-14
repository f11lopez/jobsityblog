<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;


trait TwitterTrait {
  
  protected $endpoint_user = 'https://api.twitter.com/2/users/by/username/';
  protected $endpoint_tweets = 'https://api.twitter.com/2/tweets?ids=1261326399320715264,1278347468690915330';
  
  /**
   * Get Id of a given username, false if it does not exist
   *
   * @return array or false
  */
  public function getTwitterUserIDByUsername($twitterUserName)
  {
    $endpoint_request = $this->endpoint_user."{$twitterUserName}?tweet.fields=id";
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
  
} //trait