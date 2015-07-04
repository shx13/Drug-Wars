<?php

/**
* Class Index
* Home page (default) controller
*/

class IndexController extends Controller {

  /*
  * construct from Controller class
  */

  public function __construct() {
    parent::__construct();
  }

  /*
  * Handles what happens when user moves to URL/index/index - or - as this is the default controller, also
  * when user moves to /index or enter your application at base level
  */

  public function index() {

    $this->View->render('index/index', // <-- path to rendered file
                  array(
                    // declaration of extra css (always set as array), included in common/header.php
                    'extraCSS' => array('index.css', 'index2.css'),

                    // declaration of extra js (always set as array), included in common/header.php
                    'extraJS' => array('common.js'),

                    // declaration of other data
                    'exampleVar' => 'test',

                    // example of extra js data
                    'screen' => Device::detectScreenResolution(),

                    // example of extra js data
                    'browser' => Device::detectBrowserSize()
                  ));

  }

}
