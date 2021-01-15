<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
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
    return view('entry.create');
  }
  
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return redirect
  */
  public function store(Request $request)
  {
    // Validate data
    $validatedData = $request->validate([
      'title' => ['required', 'max:255'],
      'body' => ['required']
    ]);
    
    // Save new entry with validated data
    $entry = Entry::create([
      'title' => $validatedData['title'],
      'body' => $validatedData['body'],
      'user_id' => auth()->user()->id
    ]);
    
    return redirect()->route('home');
  }
  
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\View\View
  */
  /*
  public function show($id)
  {
    return view('entry.show', [
      'entry' => Entry::findOrFail($id)
    ]);
  }
  */
  
  /**
   * Display the specified resource.
   *
   * @param  \App\Entry  $entry
   * @return \Illuminate\View\View
  */
  public function show(Entry $entry)
  {
    return view('entry.show', [
      'entry' => $entry
    ]);
  }
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\View\View
  */
  /*
  public function edit($id)
  {
    return view('entry.edit', [
      'entry' => Entry::findOrFail($id)
    ]);
  }
  */
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Entry  $entry
   * @return \Illuminate\View\View
  */
  public function edit(Entry $entry)
  {
    return view('entry.edit', [
      'entry' => $entry
    ]);
  }  

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return redirect
  */
  /*
  public function update(Request $request)
  {
    // Validate data
    $validatedData = $request->validate([
      'title' => ['required', 'max:255'],
      'body' => ['required']
    ]);
    
    // Update entry with validated data
    $entry = Entry::findOrFail($request->id);
    $entry->title = $validatedData['title'];
    $entry->body = $validatedData['body'];
    $entry->save();

    return redirect()->route('home');
  }
  */
  
  /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Entry  $entry
    * @return redirect
  */
  public function update(Request $request, Entry $entry)
  {
    // Validate data
    $validatedData = $request->validate([
      'title' => ['required', 'max:255'],
      'body' => ['required']
    ]);
    
    // Update entry with validated data
    $entry->title = $validatedData['title'];
    $entry->body = $validatedData['body'];
    $entry->save();

    return redirect()->route('home');
  }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return redirect
  */
  /*
  public function destroy($id)
  {
    Entry::findOrFail($id)->delete();
    return redirect()->route('home');
  }
  */
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Entry  $entry
   * @return redirect
  */
  public function destroy(Entry $entry, Request $request)
  {
    // Delete Entry
    $entry->delete();
    
    return redirect()->route('home');
  }
  
} //class