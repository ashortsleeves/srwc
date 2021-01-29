@if(has_post_thumbnail())
  <section class="page-header responsive-hero jumbo-bg">
    <div class="container">
      <h1>{!! App::title() !!}</h1>
    </div>
  </section>
@else
  <div class="page-header">
    <h1>{!! App::title() !!}</h1>
  </div>
@endif
