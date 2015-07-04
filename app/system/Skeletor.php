<?php

/*
* Class Skeletor
* Big boss of all classess, main part of the app
*/
 
class Skeletor {

  // set by Skeletor construct
  private $controller;
  private $parameters = array();

  // set by parseURL method
  private $controller_name;
  private $action_name;

  /*
  * Start the app, parse URL's, call according controller/method or move to 404 error
  */
  public function __construct() {

    // create array with URL parts in $url
    $this->parseURL();

    // check for controller: no controller given ? load default controller (from config)
    if (!$this->controller_name) {
      $this->controller_name = Config::get('DEFAULT_CONTROLLER');
    }

    // check for action: no action given ? load default action (from config)
    if (!$this->action_name OR (strlen($this->action_name) == 0)) {
      $this->action_name = Config::get('DEFAULT_ACTION');
    }

    // rename controller name to real controller class/file name ("index" to "IndexController")
    $this->controller_name = ucwords($this->controller_name) . 'Controller';

    // does such a controller exist ?
    if (file_exists(Config::get('PATH_CONTROLLER') . $this->controller_name . '.php')) {

      // load this file and create this controller
      // example: if controller would be "car", then this line would translate into: $this->car = new car();
      require Config::get('PATH_CONTROLLER') . $this->controller_name . '.php';
      $this->controller = new $this->controller_name();

      // check for method: does such a method exist in the controller ?
      if (method_exists($this->controller, $this->action_name)) {
        if (!empty($this->parameters)) {
          // call the method and pass arguments to it
          call_user_func_array(array($this->controller, $this->action_name), $this->parameters);
        } else {
          // if no parameters are given, just call the method without parameters, like $this->index->index();
          $this->controller->{$this->action_name}();
        }
      }

      // if a method does not exist, move to 404 error
      else {
        header('location: ' . Config::get('URL') . 'error');
      }
    }

    // if a controller does not exist, move to 404 error
    else {
      header('location: ' . Config::get('URL') . 'error');
    }

  }

  /*
  * parse the URL
  */
  private function parseURL() {

    if (Request::get('url')) {

      // split URL
      $url = trim(Request::get('url'), '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);

      // put URL parts into according properties
      $this->controller_name = isset($url[0]) ? $url[0] : null;
      $this->action_name = isset($url[1]) ? $url[1] : null;

      // remove controller name and action name from the split URL
      unset($url[0], $url[1]);

      // rebase array keys and store the URL parameters
      $this->parameters = array_values($url);
    }
  }

}
