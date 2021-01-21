@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card border-success">
          <div class="card-header bg-success">
            <big class="col-md-4 font-weight-bold text-white">{{ $entry->title }}</big>
            <small class="text-white">{{ date('H:i e \o\n d/m/Y', strtotime($entry->created_at)) }}</small>
          </div>
          <div class="card-body">
            <p class="card-text">{{ $entry->body }}</p>
          </div>
          <div class="card-footer bg-success">
            <p class="card-text mb-1">
              <a class="btn btn-light btn-sm" role="button" href="{{ url()->previous() }}">&laquo; {{ __('Back') }}</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection