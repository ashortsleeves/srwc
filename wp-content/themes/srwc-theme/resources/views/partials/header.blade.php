<header class="banner">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}"><img src="{{$header['logo']['url']}}" alt="{{ get_bloginfo('name', 'display') }}"  /></a>
    <nav class="nav-primary">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'walker' => new wp_bootstrap_navwalker(), 'menu_class' => 'nav']) !!}
      @endif
    </nav>
    <a class="btn" href="{{$header['btn']['url']}}"><i class="fas fa-heart"></i>{!! $header['btn']['title'] !!}</a>
    <button class="hamburger">
      <span>toggle menu</span>
    </button>
  </div>
  @if($header['banner'])
    <a href="{{$header['banner']['url']}}" class="banner"><span>{!! $header['banner']['title'] !!}</span></a>
  @endif
</header>

<div class="sideNav" id="sideNav">
  <nav class="nav-primary">
    @if (has_nav_menu('primary_navigation'))
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'walker' => new wp_bootstrap_navwalker(), 'menu_class' => 'nav']) !!}
    @endif
  </nav>
</div>
