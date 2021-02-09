@if(has_post_thumbnail())
  <section class="page-header responsive-hero jumbo-bg">
    <div class="container">
      <h1>{!! App::title() !!}</h1>
    </div>
  </section>
@else
  <img class="pine" src="{{get_template_directory_uri()}}/assets/images/pine-branch.jpg" alt="pine-branch" />
  <div class="page-header simple-header">
    <div class="container">
      <h1>{!! App::title() !!}</h1>
    </div>
  </div>
@endif
