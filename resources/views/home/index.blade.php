@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card-deck">
      <div class="card border-success mb-2">
        <div class="card-body">
          <h5 class="card-title text-success">{{ $entriesTitle }}</h5>
          @if (count($entries) === 0)
            <p class="card-text">You currently don't have any entries.</p>            
          @else
            <ul class="list-group">
              @foreach($entries as $entry)
                <li class="list-group-item border-success">
                  <p class="card-text text-success mb-1">
                    <big class="font-weight-bold text-dark">{{ $entry->title }}</big> <small class="text-dark">{{ date('H:i e \o\n d/m/Y', strtotime($entry->created_at)) }}</small>
                  </p>
                  <p class="card-text mb-1">{{ \Illuminate\Support\Str::limit($entry->body, 50, $end='...') }}</p>
                  <div class="row">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="col-xs-6"><a href="{{ route('entry.show',[$entry->id]) }}" class="btn btn-outline-success btn-sm" role="button">{{ __('Show') }}</a></div>
                    &nbsp;
                    <div class="col-xs-6"><a href="{{ route('entry.edit',[$entry->id]) }}" class="btn btn-outline-secondary btn-sm" role="button">{{ __('Edit') }}</a></div>
                    &nbsp;
                    <div class="col-xs-6">
                      <form method="POST" action="{{ route('entry.destroy',[$entry->id]) }}">
                        @csrf
                        <input type="hidden" id="_method" name="_method" value="DELETE" />
                        <button type="submit" class="btn btn-outline-danger btn-sm">{{ __('Delete') }}</button>
                      </form>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
        <div class="card-footer bg-transparent border-0">
          <p class="card-text"><small><a class="text-success" href="{{ route('entry.create') }}">{{ __('Create a Blog Entry') }}</a></small></p>
        </div>
      </div>
      
      <div class="card border-primary mb-2">
        <div class="card-body">
          <h5 class="card-title text-primary">{{ $tweetsTitle }}</h5>
          <ul class="list-group">
            @foreach($tweets['data'] as $tweet)
              <li class="list-group-item border-primary">
                <p class="card-text mb-1">{{ \Illuminate\Support\Str::limit($tweet['text'], 50, $end='...') }}</p>
                <div class="row">
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <div class="col-xs-6"><a href="{{ route('tweet.show',[$tweet['id']]) }}" class="btn btn-outline-primary btn-sm" role="button">{{ __('Show') }}</a></div>
                  &nbsp;
                  <div class="col-xs-6">
                    <form method="POST" action="{{ route('entry.destroy',[$tweet['id']]) }}">
                      @csrf
                      <input type="hidden" id="_method" name="_method" value="DELETE" />
                      <button type="submit" class="btn btn-outline-danger btn-sm">{{ __('Hide') }}</button>
                    </form>
                  </div>
                  &nbsp;
                  <small class="text-primary">{{ date('H:i e \o\n d/m/Y', strtotime($tweet['created_at'])) }}</small>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
        <div class="card-footer bg-transparent border-0">
          @if (isset($tweets['meta']['previous_token']))
            <a href="{{ route('home',[$tweets['meta']['previous_token']]) }}" class="btn btn-outline-primary btn-sm" role="button">&laquo; Previous</a>
          @endif
          @if (isset($tweets['meta']['next_token']))
            <a href="{{ route('home',[$tweets['meta']['next_token']]) }}" class="btn btn-outline-primary btn-sm" role="button">Next &raquo;</a>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection