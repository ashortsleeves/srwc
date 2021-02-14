export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired

    var removeClass = true;
    $('.hamburger').click(function () {
      $('.hamburger').toggleClass('is-active');
      $('#sideNav').toggleClass('sideNav-open');
      $('.sideNavBody').toggleClass('sideNavBody-push');
      removeClass = false;
    });

    $('.sideNav').click(function() {
      removeClass = false;
    });

    document.addEventListener('touchstart', function(e) {
      if (removeClass && !$(e.target).hasClass('sideNav') && $('.sideNav').has($(e.target)).length === 0) {
         $('.hamburger').removeClass('is-active');
         $('#sideNav').removeClass('sideNav-open');
         $('.sideNavBody').removeClass('sideNavBody-push');
      }
      removeClass = true;
    }, false);

  },
};
