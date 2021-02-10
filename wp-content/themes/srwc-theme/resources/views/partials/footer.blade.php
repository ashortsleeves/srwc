<section class="footer-cta">
  <img class="mountains" src="{{get_template_directory_uri()}}/assets/images/footer-mtns.jpg" alt="Mountains and River" />
  <div class="container">
    <div class="cta">
      <div class="ci-border ci-border-1"></div>
      <div class="ci-border ci-border-2"></div>
      {!!$footer['cta']!!}
    </div>
  </div>
</section>
<section class="footer-map">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-content">
        {!!$footer['map-content']!!}
      </div>
      <div class="col-md-6">
        <div class="map-responsive">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2881.645434764985!2d-70.65992268449878!3d43.75945917911777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cb2ef84e4dc31cf%3A0xa8d2ccc644652cdf!2sSaco%20River%20Wildlife%20Center!5e0!3m2!1sen!2sus!4v1612806638186!5m2!1sen!2sus" width="600" height="330" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
<footer class="content-info">
  <div class="container">
    <img src="{{$footer['logo']['url']}}" alt="{{ get_bloginfo('name', 'display') }}"  />
    <a class="btn" href="{{$header['btn']['url']}}"><i class="fas fa-heart"></i>{!! $header['btn']['title'] !!}</a>
    <nav class="nav-primary">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
    <div class="socials">
      @if($footer['site-info']['facebook'])
        <a class="social-icon" href="{!!$footer['site-info']['facebook']!!}"><i class="fab fa-facebook"></i></a>
      @endif
      @if($footer['site-info']['instagram'])
        <a target="_blank" class="social-icon" href="{!!$footer['site-info']['instagram']!!}"><i class="fab fa-instagram"></i></a>
      @endif
      @if($footer['site-info']['tiktok'])
        <a target="_blank" class="social-icon" href="{!!$footer['site-info']['tiktok']!!}"><i class="fab fa-tiktok"></i></a>
      @endif
      @if($footer['site-info']['twitter'])
        <a target="_blank" class="social-icon" href="{!!$footer['site-info']['twitter']!!}"><i class="fab fa-twitter"></i></a>
      @endif
    </div>
  </div>
</footer>
<div class="copyright">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-copyright">
        © Copyright {{ date("Y") }} - Saco River Wildlife Center - Website by <a target="_blank" href="https://www.crafticonic.com/">Craft Iconic Web Design</a>
      </div>
    </div>
  </div>
</div>
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "LocalBusiness",
  "name": "{{ get_bloginfo('name', 'display') }}",
  "telephone": "207-512-8934",
  "address":
  [
    "@type": "PostalAddress",
    "streetAddress": "{!! $footer['site_info']['address'] !!}",
    "addressLocality": "{!! $footer['site_info']['town'] !!}",
    "addressRegion": "{!! $footer['site_info']['state'] !!}",
    "postalCode": "{!! $footer['site_info']['zip'] !!}"
  ]
}
</script>
