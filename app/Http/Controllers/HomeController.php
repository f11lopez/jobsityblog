<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use App\Traits\TwitterTrait;

class HomeController extends Controller
{
  
  use TwitterTrait;
  
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
    $twitter_userID = auth()->user()->twitter_userid;
    
    // Get all author's entries
    $oEntries = Entry::where('user_id', $user_id)->orderBy('created_at','desc')->get();
    
    // Get twitter timeline
    $aTwitterTimeline = $this->getTwitterTimelineByUserID($twitter_userID);
    
    // Render the view with all the author's entries
    return view( 'home.index', [ 'entriesTitle' => 'My Blog Entries' . ' (' . count($oEntries) . ')',
                                 'entries' => $oEntries,
                                 'tweetsTitle' => 'My Twitter Entries' . ' (' . count($aTwitterTimeline) . ')',
                                 'tweets' => $aTwitterTimeline ] );
  }

} //class