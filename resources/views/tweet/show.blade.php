@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card border-primary">
          @if (isset($tweet['error']))
            <div class="card-header bg-primary text-white">
              <big>{{$tweet['error']['title']}}</big>
            </div>
            <div class="card-body">
              <p class="card-text">
                {{$tweet['error']['detail']}}
              </p>
            </div>
            <div class="card-footer bg-transparent border-0">
              <p class="card-text mb-1"><a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm" role="button">&#171; {{ __('Back') }}</a></p>
            </div>
          @elseif ($tweet === false)
            <div class="card-header bg-primary text-white">
              <big>{{ __('Unknown Error!') }}</big>
            </div>
            <div class="card-body">
              <p class="card-text"></p>
            </div>
            <div class="card-footer bg-transparent border-0">
              <p class="card-text mb-1"><a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm" role="button">&#171; {{ __('Back') }}</a></p>
            </div>
          @else
            <div class="card-header bg-primary">
              <img src="{{ $tweet['user']['profile_image_url'] }}" alt="{{ $tweet['user']['name'] }}" class="rounded-circle float-left">
              <big><a href="{{ $tweet['user']['url'] }}" class="col-md-4 font-weight-bold text-white" target="_blank">&#x00040;{{ $tweet['user']['username'] }}</a></big>
              <small class="text-white">{{ date('H:i e \o\n d/m/Y', strtotime($tweet['created_at'])) }}</small>
            </div>
            <div class="card-body">
              {{-- Tweet Text --}}
              <p class="card-text">
                {!! html_entity_decode($tweet['text']) !!}
              </p>
              {{-- Tweet Media --}}
              @if (isset($tweet['media']))
                <div id="carouselTweetMedia" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    @foreach( $tweet['media'] as $key => $media)
                      <div class="carousel-item {{ $key==0 ? 'active' : ''  }}">
                        <img class="d-block w-100" src="{{$media}}" alt="Photo_{{$key}}">
                      </div>
                    @endforeach
                  </div>
                  @if (count($tweet['media']) > 1)
                    <a class="carousel-control-prev" href="#carouselTweetMedia" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselTweetMedia" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  @endif
                </div>
              @endif
            </div>
            <div class="card-footer bg-primary">
              <div class="row">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <p class="card-text mb-1">
                  <a class="btn btn-light btn-sm" role="button" href="{{ url()->previous() }}">&#171; {{ __('Back') }}</a>
                </p>
                &nbsp;
                <p class="card-text mb-1">
                  <a class="btn btn-light btn-sm" role="button" href="https://twitter.com/{{ $tweet['user']['username'] }}/status/{{ $tweet['id'] }}" target="_blank">{{ __('Show in Twitter') }}</a>
                </p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection