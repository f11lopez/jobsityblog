<?php

namespace App\Http\Controllers;

use App\Traits\TwitterTrait;


class TestController extends Controller
{
  
  use TwitterTrait;
  
  public function getUserID($username = 'jeremyjones') {
    $userID = $this->getTwitterUserIDByUsername($username);
    dd($userID);
  }
  
  public function getUserTimeline($userID = '12381102') {
    $userTimeline = $this->getTwitterTimelineByUserID($userID);
    dd($userTimeline);
  }  
  
} //class