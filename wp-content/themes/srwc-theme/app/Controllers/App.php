<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public function header() {
      $data = [
        'logo'       => get_field('logo', 'option'),
        'btn'        => get_field('header_button', 'option'),
        'banner'     => get_field('header_banner', 'option'),
      ];

      return $data;
    }

    public function footer() {
      $data = [
        'cta'         => get_field('contact_footer_content', 'option'),
        'map-content' => get_field('footer_map_content','option'),
        'logo' => get_field('footer_logo','option'),
        'site-info' => get_field("site_info", 'option'),

      ];

      return $data;
    }
}
