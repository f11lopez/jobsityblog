@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card border-success">
          <div class="card-header bg-success text-white">{{ __('Edit Blog Entry') }}</div>
          <div class="card-body">
            <form method="POST" action="{{ route('entry.update',[$entry->id]) }}">
              @csrf
              <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label text-md-right text-success">{{ __('Title') }}</label>
                <div class="col-md-6">
                  <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $entry->title }}" required autocomplete="title" autofocus>
                  @error('title')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="body" class="col-md-4 col-form-label text-md-right text-success">{{ __('Body') }}</label>
                <div class="col-md-6">
                  <textarea id="body" class="form-control @error('body') is-invalid @enderror" name="body" rows="5" required>{{ $entry->body }}</textarea>
                  @error('body')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <a class="btn btn-success" role="button" href="{{ url()->previous() }}">&laquo; {{ __('Back') }}</a>
                  <button type="submit" class="btn btn-success">
                    {{ __('Update') }}
                  </button>
                </div>
              </div>
              <input type="hidden" id="_method" name="_method" value="PUT" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection