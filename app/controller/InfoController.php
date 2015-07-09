<?php

/*
* Class Info
* Game Instructions & Top Scores
*/

class InfoController extends Controller {

  /*
  * construct from Controller class
  */

  public function __construct() {
    parent::__construct();
  }

  /*
  * Display game manual - /info/instructions
  */

  public function instructions() {
    $this->View->render('info/instructions'); // <-- path to rendered file
  }

  /*
  * Display Top Scores - /info/top_scores
  */

  public function top_scores() {
    $this->View->render('info/top_scores', // <-- path to rendered file
                  array(
                    // get top scores
                    'ranking' => GameModel::get_ranking()
                  ));
  }

}
