@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card border-success">
          <div class="card-header bg-success">
            <big class="text-white">{{ $entry->title }}</big> <small class="text-white">({{ date('H:i e \o\n d/m/Y', strtotime($entry->created_at)) }})</small>
          </div>
          <div class="card-body">
            <p class="card-text">{{ $entry->content }}</p>
            <p class="card-text mb-1"><a href="{{ url()->previous() }}" class="btn btn-outline-success btn-sm" role="button">&#171; {{ __('Back') }}</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


                  
                  
