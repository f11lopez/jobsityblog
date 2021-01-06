@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <!-- Display Entries -->
      <div class="col-sm-8">
        @if ($alert)
          <div class="alert alert-success" role="alert">
            {{ $alert }}
          </div>
        @endif        
        <div class="card">
          <div class="card-header">{{ $pageTitle }}</div>
          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif
            <ul class="list-group">
              @if (count($entries) === 0)
                You currently don't have any entries yet. <a href="{{ route('entries.create') }}">{{ __('Create a Blog Entry') }}</a>
              @else
                @foreach($entries as $entry)
                  <li class="list-group-item">
                    <span class="entry-date">{{ $entry['created_at'] }}</span>
                    <h4 class="list-group-item-heading">
                      <a href="{{ route('entries.show',[$entry->id]) }}">{{ $entry->title }}</a>
                    </h4>
                    <p class="list-group-item-text">
                      {{ $entry->content }}
                    </p>
                    @auth
                      @if ($author_id === Auth::user()->id)
                        <div class="row">
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <div class="col-xs-6">
                            <a href="{{ route('entries.edit',[$entry->id]) }}" class="btn btn-outline-dark btn-sm" role="button">{{ __('Edit') }}</a>
                          </div>
                          &nbsp;
                          <div class="col-xs-6">
                            <form method="POST" action="{{ route('entries.destroy',[$entry->id]) }}">
                              @csrf
                              <input type="hidden" id="_method" name="_method" value="DELETE" />
                              <button type="submit" class="btn btn-outline-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                          </div>
                        </div>
                      @endif
                    @endauth
                  </li>
                  <br/>
                @endforeach                
              @endif
            </ul>
          </div>
        </div>
      </div>
      <!-- Display Tweets -->
      <div class="col-sm-3">
        <!-- Tweets actions feedback messages -->
        <div id="tweetsFeedback" style="display: none;" role="alert"></div>
        <div class="card">
          <div class="card-header">
            <img class="twitter-logo" src="../img/Twitter_Logo_Blue.png" alt="Twitter Logo">&nbsp;{{ __('Tweets') }}
          </div>
          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif
            <ul class="list-group">
              @foreach($tweets as $tweet)
                  @auth
                    <li class="list-group-item">
                      <a target="_blank" href="https://twitter.com/{{ $tweet->user->screen_name }}">
                        <img class="twitter-avatar" src="{{ $tweet->user->profile_image_url }}" alt="{{ $tweet->user->screen_name }}">
                        &nbsp;{{ $tweet->user->name }} - &#64;<b>{{ $tweet->user->screen_name }}</b>
                      </a>
                      <span class="entry-date">{{ date('M d', strtotime($tweet->created_at)) }}</span>
                      {{ $tweet->text }}
                      @if ($author_id === Auth::user()->id)
                        <div class="row">
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <div class="col-xs-6">
                            @if (isset($tweet->hidden_tweet) && $tweet->hidden_tweet)
                              <span class="hidden-tweet">Hidden Tweet</span>
                              <a id="show-tweet" href="#" class="btn btn-outline-success btn-sm" role="button" data-author-id="{{ $author_id }}" data-tweet-id="{{ $tweet->id_str }}" data-csrf="{{ csrf_token() }}">{{ __('Show') }}</a>
                            @else
                              <span class="visible-tweet">Visible Tweet</span>
                              <a id="hide-tweet" href="#" class="btn btn-outline-danger btn-sm" role="button" data-author-id="{{ $author_id }}" data-tweet-id="{{ $tweet->id_str }}" data-csrf="{{ csrf_token() }}">{{ __('Hide') }}</a>
                            @endif
                          </div>
                        </div>
                      @endif
                    </li>
                  @else
                    @if (isset($tweet->hidden_tweet) && $tweet->hidden_tweet)
                      @continue
                    @else
                      <li class="list-group-item">
                        <a target="_blank" href="https://twitter.com/{{ $tweet->user->screen_name }}">
                          <img class="twitter-avatar" src="{{ $tweet->user->profile_image_url }}" alt="{{ $tweet->user->screen_name }}">
                          &nbsp;{{ $tweet->user->name }} - &#64;<b>{{ $tweet->user->screen_name }}</b>
                        </a>
                        <span class="entry-date">{{ date('M d', strtotime($tweet->created_at)) }}</span>
                        {{ $tweet->text }}
                      </li>
                    @endif
                  @endauth
                <br/>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      
    </div>
  </div>
@endsection