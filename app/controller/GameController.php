<?php

/*
* Class Game
* Main class of the game. Controls all the game actions.
*/

class GameController extends Controller
{
  /*
  * Construct this object by extending the basic Controller class
  * If the game is not on, don't let the user in (could move this to system/Auth in the future...)
  */
  public function __construct()
  {
    parent::__construct();
    if(Session::get('game') != 'on'
    && Session::get('game') != 'final_score'
    && Session::get('game') != 'end_screen') {
      Redirect::home();
    }
  }

  /*
  * Main screen of the game. Also, if the game 'doesn't know' what to do,
  * it redirects the user here. That's why it also handles stuff like
  * time limit or final_score / end_screen methods. 
  */
  public function index() {

    // if the game is not running in normal mode...
    if(Session::get('game') != 'on') {

      // final score (the game is finished and the player is prompted for name)
      if(Session::get('game') == 'final_score') { Redirect::to('game/final_score/'); }

      // end screen (the game is finished)
      elseif(Session::get('game') == 'end_screen') { Redirect::to('game/end_screen/'); }

      // go back to main menu
      else { Redirect::home(); }

      return false;
    }

    // game hits its time limit - stop it and send the user to final_score screen
    if(Session::get('game_date') > Config::get('END_GAME_DATE')) {

      // change the game mode
      Session::set('game','final_score');

      // send the user to final_score screen
      Redirect::to('game/final_score/');

      return false;
    }

    // start rendering the View
    // render the header, include javascript files
    $this->View->basicRender('common/header', // <-- path to rendered file
                       array(
                         // declaration of extra css (always set as array), included in common/header.php
                         'extraCSS' => array('index.css', 'index2.css'),
      
                         // declaration of extra js (always set as array), included in common/header.php
                         'extraJS' => array('game.js')
                       ));

    /*
    * Normally, the game always shows the main table, except the fights with
    * officer hardass (it's a random encounter). 
    */

    if(Session::get('user_action') == 31 OR Session::get('user_action') == 32) {
      $this->View->basicRender('game/hardass');
    } else {
      $this->View->basicRender('game/main_table');
    }

    /*
    * By default, display the basic game options (buy, sell, jet + bronx opts)
    * If user_action != null, display the options from random encounter
    * (i.e. do you want to buy new coat? yes / no)
    */

    if(Session::get('user_action') == null) {
      $this->View->basicRender('game/action_menu');
    } else {
      $this->View->basicRender('game/action_menu_2');
    }

  }

  // start new game
  public function start_game() {
    GameModel::start_new_game();
    Redirect::to('game/');
  } 

  // final_score screen - the game hits the time limit and prompts the user for name
  public function final_score() {

    // check if the game has really ended
    if(Session::get('game') != 'final_score') {
      Redirect::to('game/');
      return false;
    }

    $this->View->render('game/final_score');
  }

  // takes player name and score and puts it into the ranking
  public function update_ranking_action() {

    // if the game's not finished, don't allow this method
    if(Session::get('game') != 'final_score') {
      Redirect::to('game/');
      return false;
    }

    GameModel::update_ranking();
    Redirect::to('game/end_screen/');
  }

  // shows player the score and ranking position
  public function end_screen() {

    // if the game's not finished, don't allow this method
    if(Session::get('game') != 'end_screen') {
      Redirect::to('game/');
      return false;
    }

    // change the game mode to null - the game is finished
    Session::set('game', null);

    $this->View->render('game/end_screen', 
                  array(
                    'ranking' => GameModel::get_ranking()
                  ));
  }

  // ends the game
  public function end_game() {
    //session_unset();
    //session_destroy();
    //session_write_close();
    //setcookie(session_name(),'',0,'/');
    //session_regenerate_id(true);
    Session::set('game',null);
    Redirect::home();
  }

  // jet to
  public function jet_to($placeId) {
    GameModel::jet_to($placeId);
    Redirect::to('game/');
  }

  // buy drugs
  public function buy($itemId) {
    GameModel::buy_item($itemId);
    Redirect::to('game/');
  }

  // sell drugs
  public function sell($itemId) {
    GameModel::sell_item($itemId);
    Redirect::to('game/');
  }

  // repay debt
  public function repay() {
    GameModel::repay();
    Redirect::to('game/');
  }

  // borrow more cash
  public function borrow() {
    GameModel::borrow();
    Redirect::to('game/');
  }

  // transfer drugs
  public function transfer_drugs() {
    GameModel::transfer_drugs();
    Redirect::to('game/');
  }

  // deposit cash onto bank account
  public function deposit() {
    GameModel::deposit();
    Redirect::to('game/');
  }

  // withdraw cash from bank account
  public function withdraw() {
    GameModel::withdraw();
    Redirect::to('game/');
  }

  // random encounter actions
  public function action() {
    GameModel::action();
    Redirect::to('game/');
  }

}
