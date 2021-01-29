{{--
  Template Name: Front Page Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @if(has_post_thumbnail())
      <section class="page-header responsive-hero jumbo-bg">
        <div class="container">
          <div class="cta">
            <div class="ci-border ci-border-1"></div>
            <div class="ci-border ci-border-2"></div>
            <span class="title">{{$cta['title']}}</span>
            <span class="subtitle">{{$cta['subtitle']}}</span>
            <a class="btn btn-green" href="{{$cta['button1']['url']}}">{!!$cta['button_1_icon']!!}{{$cta['button1']['title']}}</a>
            <a class="btn btn-darkgreen" href="{{$cta['button_2']['url']}}">{!!$cta['button_2_icon']!!}{{$cta['button_2']['title']}}</a>
          </div>
        </div>
      </section>
    @endif

  @endwhile
@endsection
