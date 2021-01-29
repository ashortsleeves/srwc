<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
  public function cta() {
    return get_field('call_to_action');
  }

  public function section() {
    return get_field('sections');
  }
}
