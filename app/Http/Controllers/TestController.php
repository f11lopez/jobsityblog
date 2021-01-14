<?php

namespace App\Http\Controllers;

use App\Traits\TwitterTrait;


class TestController extends Controller
{
  
  use TwitterTrait;
  
  protected $amount;
  protected $base_currency_code;
  protected $base_currency_desc;
  protected $target_currency_code;
  protected $target_currency_desc;
  
  /*
  public function __construct($amount, $base_currency, $target_currency) {
    $this->amount = trim($amount);
    $this->base_currency_code = trim($base_currency);
    $this->target_currency_code = trim($target_currency);
  }
  */
  
  public function getUserID($username = 'jeremyjones') {
    $userID = $this->getTwitterUserIDByUsername($username);
    dd($userID);
  }
  
} //class