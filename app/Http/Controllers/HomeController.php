<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index(Request $request)
  {
    $user_id = auth()->user()->id;
    $user_name = auth()->user()->name;
    $user_twitter = auth()->user()->twitter_username;
    
    // Get all author's entries
    $entries = Entry::where('user_id', $user_id)->orderBy('created_at','desc')->get();
    
    // Get all author's tweets
    $tweets = array();
    
    // Render the view with all the author's entries
    return view( 'home.index', [ 'entriesTitle' => 'My Blog Entries' . ' (' . count($entries) . ')',
                                 'entries' => $entries,
                                 'tweetsTitle' => 'My Twitter Entries' . ' (' . count($tweets) . ')',
                                 'tweets' => $tweets ] );
  }

} //class