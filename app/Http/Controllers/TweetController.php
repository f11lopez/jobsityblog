<?php

namespace App\Http\Controllers;

use App\Traits\TwitterTrait;

class TweetController extends Controller
{
    
  use TwitterTrait;
    
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
  }
    
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }
    
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }
  
  /**
   * Display the specified tweet.
   *
   * @param  int  $id
   * @return \Illuminate\View\View
  */
  public function show($id)
  {
    // Get tweet
    $aTweet = $this->getTweetByID($id);    
    return view('tweet.show', [
      'tweet' => $aTweet
    ]);
  }
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
  }
    
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    //
  }
    
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }

} //class