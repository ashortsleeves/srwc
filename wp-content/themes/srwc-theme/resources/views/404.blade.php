@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="container container-sm container-404">
      <h3>{{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}</h3>
      <button class="btn btn-lg" onclick="goBack()"><i class="fas fa-arrow-left"></i> Go Back</button>

      <script>
      function goBack() {
        window.history.back();
      }
      </script>

    </div>

  @endif
@endsection
