{{--
  Template Name: Contact Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    <div class="container interior-container">
      <div class="row">
        <div class="col-md-6">
          @include('partials.content-page')
        </div>
        <div class="col-md-6 col-content contact-map">
          <section class="footer-map cardstyle">
          {!!$footer['map-content']!!}
            <div class="map-responsive">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2881.645434764985!2d-70.65992268449878!3d43.75945917911777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cb2ef84e4dc31cf%3A0xa8d2ccc644652cdf!2sSaco%20River%20Wildlife%20Center!5e0!3m2!1sen!2sus!4v1612806638186!5m2!1sen!2sus" width="600" height="330" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
          </section>
        </div>
      </div>
    </div>
  @endwhile
@endsection
