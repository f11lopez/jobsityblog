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
                    <big class="font-weight-bold text-dark">{{ $entry->title }}</big> <small class="text-dark">({{ date('H:i e \o\n d/m/Y', strtotime($entry->created_at)) }})</small>
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
          <p class="card-text"><small class="text-success"><a href="{{ route('entry.create') }}">{{ __('Create a Blog Entry') }}</a></small></p>
        </div>
      </div>
      
      <div class="card border-primary mb-2">
        <div class="card-body">
          <h5 class="card-title text-primary">{{ $tweetsTitle }}</h5>
          <p class="card-text">Perform currency exchange by answering the questions the Chatbot will ask you.</p>
          <p class="card-text">Please check the list of supported currency codes below.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">convert</medium> or <medium class="font-weight-bold">exchange</medium> to start the process.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">exit</medium> to quit the conversation.</p>
        </div>
        <div class="card-footer bg-transparent border-0"><p class="card-text"><small class="text-primary">No login needed.</small></p></div>
      </div>
    </div>
  </div>
@endsection