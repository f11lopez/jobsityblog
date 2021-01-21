<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;


trait TwitterTrait {
  
  protected $endpoint_user = 'https://api.twitter.com/2/users/by/username/{{username}}?tweet.fields=id';
  protected $endpoint_timeline = 'https://api.twitter.com/2/users/{{userid}}/tweets?max_results=5&tweet.fields=id,created_at,text';
  protected $endpoint_tweet = 'https://api.twitter.com/2/tweets/{{tweetid}}?tweet.fields=created_at,id,text,entities&expansions=author_id,attachments.media_keys&user.fields=profile_image_url,url,username&media.fields=preview_image_url,url';
  
  protected $link_mentions = "<a href=\"https://twitter.com/{{username}}\" target=\"_blank\">@{{username}}</a>";
  protected $link_hashtags = "<a href=\"https://twitter.com/hashtag/{{tag}}\" target=\"_blank\">#{{tag}}</a>";
  protected $link_urls = "<a href=\"{{url}}\" target=\"_blank\">{{display_url}}</a>";
  
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
  public function getTwitterTimelineByUserID($twitterUserID, $pagination_token=false)
  {
    $endpoint_request = $pagination_token ? str_replace('{{userid}}',$twitterUserID,$this->endpoint_timeline) . '&pagination_token=' . $pagination_token : str_replace('{{userid}}',$twitterUserID,$this->endpoint_timeline);
    $aResponse = Http::withToken(env('TWITTER_BEARER_TOKEN', false))->get($endpoint_request)->json();
    //success
    if (isset($aResponse['data'])) {
      //save newest tweet id form the first page of the timeline
      if (!isset($aResponse['meta']['previous_token'])) {
        session(['first_page_newest_id' => $aResponse['meta']['newest_id']]);
      }
      $aResponse['meta']['first_page_newest_id'] = session('first_page_newest_id');
      return $aResponse;
    }
    //failure
    else {
      /*
      $endpoint_request = str_replace('{{userid}}',$twitterUserID,$this->endpoint_timeline);
      $aResponse = Http::withToken(env('TWITTER_BEARER_TOKEN', false))->get($endpoint_request)->json();
      //success
      if (isset($aResponse['data'])) {
        return $aResponse;
      }
      //failure
      else {
      */
        return false;
      //}
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
    $aReturn = array();
    //success
    if (isset($aResponse['data'])) {
      $aReturn = $this->processTweetResponse($aResponse);
      return $aReturn;
    }
    //failure
    else {
      if (isset($aResponse['errors'][0])) {
        $aReturn['error'] = $aResponse['errors'][0];
        return $aReturn;
      }
      else
        return false;
    }
  }
  
  /**
   * Process the Tweet text
   *
   * @return array or false
  */
  private function processTweetResponse($aTweetResponse)
  {
    $aReturn = array();
    // Add tweet entities into text
    $aReturn['text'] = isset($aTweetResponse['data']['entities']) ? $this->loadTweetEntities($aTweetResponse['data']['text'],$aTweetResponse['data']['entities']) : $aTweetResponse['data']['text'];
    // Add tweet creation date info
    $aReturn['created_at'] = $aTweetResponse['data']['created_at'];
    // Add tweet id info
    $aReturn['id'] = $aTweetResponse['data']['id'];
    // Add tweet author info
    if (isset($aTweetResponse['includes']['users'][0]))
      $aReturn['user'] = $aTweetResponse['includes']['users'][0];
    // Add tweet media info
    if (isset($aTweetResponse['includes']['media']))
      $aReturn['media'] = $this->loadTweetMedia($aTweetResponse['includes']['media']);
    
    return $aReturn;
  }
  
  /**
   * Process the Tweet text
   *
   * @return array or false
  */
  private function loadTweetEntities($sTweetText,$aTweetEntities)
  {
    // Process Tweet Mentions
    if (isset($aTweetEntities['mentions']))
      $this->loadTweetMentions($sTweetText,$aTweetEntities['mentions']);
      
    // Process Tweet Hashtags
    if (isset($aTweetEntities['hashtags']))
      $this->loadTweetHashtags($sTweetText,$aTweetEntities['hashtags']);
      
    // Process Tweet Urls
    if (isset($aTweetEntities['urls']))
      $this->loadTweetUrls($sTweetText,$aTweetEntities['urls']);
      
    return $sTweetText;
  }
  
  /**
   * Add mentions to Tweet text
   *
  */
  private function loadTweetMentions(&$sTweetText,$aTweetMentions)
  {
    foreach($aTweetMentions as $value) {
      $link_mention = str_replace('{{username}}',$value['username'],$this->link_mentions);
      $sTweetText = str_replace("@{$value['username']}",$link_mention,$sTweetText);
    }
  }
  
  /**
   * Add hashtags to Tweet text
   *
  */
  private function loadTweetHashtags(&$sTweetText,$aTweetHashtags)
  {
    foreach($aTweetHashtags as $value) {
      $link_hashtag = str_replace('{{tag}}',$value['tag'],$this->link_hashtags);
      $sTweetText = str_replace("#{$value['tag']}",$link_hashtag,$sTweetText);
    }
  }
  
  /**
   * Add urls to Tweet text
   *
  */
  private function loadTweetUrls(&$sTweetText,$aTweetUrls)
  {
    foreach($aTweetUrls as $value) {
      //Convert external urls
      if (isset($value['unwound_url'])) {
        $link_url = str_replace('{{url}}',$value['unwound_url'],$this->link_urls);
        $link_url = str_replace('{{display_url}}',$value['display_url'],$link_url);
        $sTweetText = str_replace($value['url'],$link_url,$sTweetText);
      }
      //Convert internal urls
      else {
        $sTweetText = str_replace($value['url'],'',$sTweetText);
      }
    }
  }  
  
  /**
   * Add Tweet media
   *
  */
  private function loadTweetMedia($aTweetMedia)
  {
    $aReturn = array();
    foreach($aTweetMedia as $value) {
      array_push($aReturn, isset($value['url']) ? $value['url'] : $value['preview_image_url']);
    }
    
    return $aReturn;
  }
  
} //trait