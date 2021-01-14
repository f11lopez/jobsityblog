<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Traits\TwitterTrait;

class RegisterController extends Controller
{
  
  /*
   |--------------------------------------------------------------------------
   | Register Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles the registration of new users as well as their
   | validation and creation. By default this controller uses a trait to
   | provide this functionality without requiring any additional code.
   |
  */
  
  use RegistersUsers;
  use TwitterTrait;
  
  /**
   * Where to redirect users after registration.
   *
   * @var string
  */
  protected $redirectTo = RouteServiceProvider::HOME;
  
  /**
   * Store the Twitter User Name.
   *
   * @var string
  */
  protected $twitterUserName = false;
  
  /**
   * Store the Twitter User ID after validation.
   *
   * @var string
  */
  protected $twitterUserID = false;  
  
  /**
   * Create a new controller instance.
   *
   * @return void
  */
  public function __construct()
  {
    $this->middleware('guest');
  }
  
  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
  */
  protected function validator(array $data)
  {
    $data['twitter_username'] = str_replace('@','',trim($data['twitter_username']));
    $this->twitterUserName = $data['twitter_username'];
    
    $validator = Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'twitter_username' => ['required', 'string', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
    
    $validator->after(function ($validator) {
      $this->twitterUserID = $this->getTwitterUserIDByUsername($this->twitterUserName);
      if (!$this->twitterUserID) {
        $validator->errors()->add(
          'twitter_username', 'The given Twitter username does not exist, please provide a valid username.'
        );
      }        
    });
    
    return $validator;
  }
  
  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Models\User
  */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'twitter_username' => $this->twitterUserName,
      'twitter_userid' => $this->twitterUserID,
      'password' => Hash::make($data['password']),
    ]);
  }

} //class