@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card border-primary">
          <div class="card-header bg-primary">
            <img src="{{ $tweet['user']['profile_image_url'] }}" alt="{{ $tweet['user']['name'] }}" class="rounded-circle float-left"><big><a href="{{ $tweet['user']['url'] }}" class="col-md-4 font-weight-bold text-white" target="_blank">&#x00040;{{ $tweet['user']['username'] }}</a></big>
          </div>
          <div class="card-body">
            <p class="card-text">{{ $tweet['text'] }}</p>            
          </div>
          <div class="card-footer bg-transparent border-0">
            <p class="card-text"><small class="text-primary">{{ date('H:i e \o\n d/m/Y', strtotime($tweet['created_at'])) }}</small></p>
            <p class="card-text mb-1"><a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm" role="button">&#171; {{ __('Back') }}</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection