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
        @if($cta['strapline'])
          <div class="strapline">
            <div class="container">
              {!!$cta['strapline']!!}
            </div>
          </div>
        @endif
      </section>
    @endif
    <div class="services">
      @foreach($sections as $section)
        <section class="service">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="cardstyle jumbo-bg" style="background-image: url({!!$section['image']['url']!!}) ">

                </div>
              </div>
              <div class="col-md-6 col-content">
                <div class="content">
                  <h1>{!!$section['title_icon']!!} {{$section['title']}}</h1>
                  <div class="text">
                    {{$section['content']}}
                  </div>
                  @if($section['button'])
                    <a class="btn" href="{{$section['button']['url']}}">{{$section['button']['title']}}</a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </section>
      @endforeach
    </div>
  @endwhile
@endsection
