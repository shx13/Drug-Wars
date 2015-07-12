<?php

/*
* GameModel
* Handles all the game stuff.
* Contains all methods required by the game.
*/

class GameModel
{

  /*
  * Starts new game - set the main game var ($_SESSION['game']) to 'on'
  * Set all other stats, set merchandise prices
  * All game variables are stored in session 
  */

  public static function start_new_game() {
    Session::set('game', 'on');
    Session::set('game_date', Options::get('START_GAME_DATE'));
    Session::set('user_location', Options::get('LOCATION_1'));
    Session::set('user_action', null);

    Session::set('stash_product_1', 0);
    Session::set('stash_product_2', 0);
    Session::set('stash_product_3', 0);
    Session::set('stash_product_4', 0);
    Session::set('stash_product_5', 0);
    Session::set('stash_product_6', 0);

    Session::set('coat_product_1', 0);
    Session::set('coat_product_2', 0);
    Session::set('coat_product_3', 0);
    Session::set('coat_product_4', 0);
    Session::set('coat_product_5', 0);
    Session::set('coat_product_6', 0);

    GameModel::reroll_products_prices();

    Session::set('hold', 100);

    Session::set('bank', 0);
    Session::set('debt', 5500);

    Session::set('guns', 0);
    Session::set('user_hp', 0);
    Session::set('cops', 0);
    Session::set('cash', 2000);

    return true;
  }


  /*
  * Re-rolls and sets new prices of all products.
  */

  public static function reroll_products_prices() {
    Session::set('price_product_1', mt_rand(Options::get('PRODUCT_1_MIN_PRICE'), Options::get('PRODUCT_1_MAX_PRICE')));
    Session::set('price_product_2', mt_rand(Options::get('PRODUCT_2_MIN_PRICE'), Options::get('PRODUCT_2_MAX_PRICE')));
    Session::set('price_product_3', mt_rand(Options::get('PRODUCT_3_MIN_PRICE'), Options::get('PRODUCT_3_MAX_PRICE')));
    Session::set('price_product_4', mt_rand(Options::get('PRODUCT_4_MIN_PRICE'), Options::get('PRODUCT_4_MAX_PRICE')));
    Session::set('price_product_5', mt_rand(Options::get('PRODUCT_5_MIN_PRICE'), Options::get('PRODUCT_5_MAX_PRICE')));
    Session::set('price_product_6', mt_rand(Options::get('PRODUCT_6_MIN_PRICE'), Options::get('PRODUCT_6_MAX_PRICE')));
    return true;
  }


  /*
  * Method responsible for moving character from city to city.
  * This method is actually the 'main' method of the game that sets it in motion.
  *
  * 1. Validate the input
  * 2. Set user_location to choosen location.
  * 3. Add 10% debt interests if any
  * 4. Add 1 day to game_date and check if it didn't hit the game limit (end of the game)
  * 5. Re-roll drugs prices
  * 6. Check for random encounters
  */

  public static function jet_to($placeId) {

    // 1. Validate the input
    $placeId = floor(htmlentities($placeId));
    if(!is_numeric($placeId) || $placeId < 1 || $placeId > 6) {
      Redirect::to('game/');
      return false;
    }

    // 2. Set user_location to choosen location.
    switch($placeId) {
      case 1:
        $location = Options::get('LOCATION_1');
        break;
      case 2:
        $location = Options::get('LOCATION_2');
        break;
      case 3:
        $location = Options::get('LOCATION_3');
        break;
      case 4:
        $location = Options::get('LOCATION_4');
        break;
      case 5:
        $location = Options::get('LOCATION_5');
        break;
      case 6:
        $location = Options::get('LOCATION_6');
        break;
    }

    Session::set('user_location', $location);

    // 3. Add 10% debt interests if any
    GameModel::add_debt_interests();

    // 4. Add 1 day to game_date and check if it didn't hit the game limit (end of the game)
    Session::set('game_date', strtotime('+1 day', Session::get('game_date')));

    if(Session::get('game_date') > Options::get('END_GAME_DATE')) {
      Redirect::to('game/final_score/');
      return false;
    }

    // 5. Re-roll drugs prices
    GameModel::reroll_products_prices();

    // 6. Check for random encounters
    $rand = mt_rand(1,100);
    if($rand <= 100) {
      GameModel::random_encounter();
    }

    return true;

  }


  /*
  * Buy drugs.
  *
  * 1. Validate the input
  * 2. Check what drugs the user wants to buy and get their local prices
  * 3. Check if the user can afford them
  * 4. Check if the user has enough space in the coat
  * 5. Take cash from player
  * 6. Remove space from coat
  * 7. Add drugs to the coat
  */

  public static function buy_item($itemId) {

    // 1. Validate the input
    $itemId = floor(htmlentities($itemId));
    if(!is_numeric($itemId) ||
       !is_numeric(Request::post('quantity')) ||
       Request::post('quantity') < 0 ||
       $itemId < 1 ||
       $itemId > 6)
    { return false; }

    // 2. Check what drugs the user wants to buy and get their prices
    switch($itemId) {
      case 1:
        $item_name = 'COCAINE';
        $item_price = Session::get('price_product_1');
        break;
      case 2:
        $item_name = 'HEROIN';
        $item_price = Session::get('price_product_2');
        break;
      case 3:
        $item_name = 'ACID';
        $item_price = Session::get('price_product_3');
        break;
      case 4:
        $item_name = 'WEED';
        $item_price = Session::get('price_product_4');
        break;
      case 5:
        $item_name = 'SPEED';
        $item_price = Session::get('price_product_5');
        break;
      case 6:
        $item_name = 'LUDES';
        $item_price = Session::get('price_product_6');
        break;
    }

    // 3. Check if the user can afford them
    if(Request::post('quantity') * $item_price > Session::get('cash')) {
      Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
      Redirect::to('game/');
      return false;
    }

    // 4. Check if the user has enough space in the coat
    if(Request::post('quantity') > Session::get('hold')) {
      Session::add('feedback_negative', 'YOUR COAT IS FULL DUDE. YOU CAN\'T HOLD ANY MORE DRUGS.');
      Redirect::to('game/');
      return false;
    }

    // 5. Take cash from player
    Session::set('cash', Session::get('cash') - Request::post('quantity') * $item_price);

    // 6. Remove space from coat
    Session::set('hold', Session::get('hold') - Request::post('quantity'));

    // 7. Add drugs to the coat
    switch($itemId) {
      case 1:
        Session::set('coat_product_1', Session::get('coat_product_1') + Request::post('quantity'));
        break;
      case 2:
        Session::set('coat_product_2', Session::get('coat_product_2') + Request::post('quantity'));
        break;
      case 3:
        Session::set('coat_product_3', Session::get('coat_product_3') + Request::post('quantity'));
        break;
      case 4:
        Session::set('coat_product_4', Session::get('coat_product_4') + Request::post('quantity'));
        break;
      case 5:
        Session::set('coat_product_5', Session::get('coat_product_5') + Request::post('quantity'));
        break;
      case 6:
        Session::set('coat_product_6', Session::get('coat_product_6') + Request::post('quantity'));
        break;
    }
  }


  /*
  * Sell merchandise.
  *
  * 1. Validate the input
  * 2. Check what goods the user wants to sell and get their local prices
  * 3. Check if the user actually has the merchandise for sale
  * 4. Remove goods from the coat
  * 5. Add space to the coat
  * 6. Give the cash from the sale to the user
  */

  public static function sell_item($itemId) {

    // 1. Validate the input
    $itemId = floor(htmlentities($itemId));
    if(!is_numeric($itemId) ||
       !is_numeric(Request::post('quantity')) ||
       Request::post('quantity') < 0 ||
       $itemId < 1 ||
       $itemId > 6)
    { Redirect::to('game/'); die(); }

    // 2. Check what goods the user wants to sell and get their local prices
    switch($itemId) {
      case 1:
        $item_id = 'product_1';
        $item_price = Session::get('price_product_1');
        break;
      case 2:
        $item_id = 'product_2';
        $item_price = Session::get('price_product_2');
        break;
      case 3:
        $item_id = 'product_3';
        $item_price = Session::get('price_product_3');
        break;
      case 4:
        $item_id = 'product_4';
        $item_price = Session::get('price_product_4');
        break;
      case 5:
        $item_id = 'product_5';
        $item_price = Session::get('price_product_5');
        break;
      case 6:
        $item_id = 'product_6';
        $item_price = Session::get('price_product_6');
        break;
    }

    // 3. Check if the user actually has enough merchandise for sale
    if(Session::get('coat_'.strtolower($item_id)) < Request::post('quantity')) {
      Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MANY, DUDE !');
      Redirect::to('game/');
      return false;
    }

    // 4. Remove goods from the coat
    Session::set('coat_'.strtolower($item_id), Session::get('coat_'.strtolower($item_id)) - Request::post('quantity'));

    // 5. Add space to the coat
    Session::set('hold', Session::get('hold') + Request::post('quantity'));

    // 6. Give the cash from the sale to the user
    Session::set('cash', Session::get('cash') + Request::post('quantity') * $item_price);
  }


  /*
  * Add interest to loan shark debt
  * Every turn, it adds 10% to the current debt value
  */

  public static function add_debt_interests() {
    $newDebt = floor(Session::get('debt') * 1.1);
    Session::set('debt', $newDebt);
    return true;
  }


  /*
  * Random encounters.
  *
  * Every turn, the game 'throws the dices' for a random encounter.
  * It can be either positive or negative.
  *
  * $dice var is a random number from 1 to 20, it selects the encounter from the list.
  * There are 15 encounters, but the last one (officer hardass) is most likely to happen
  * $multiplier var is a random number from 2 to 10, it is used by some of the encounters
  * for further calculations (i.e. price drops) 
  *
  * Encounters list:
  *
  * 01. Cocaine price * $multiplier                  - COPS MADE A BIG COKE BUST !!  PRICES ARE OUTRAGEOUS !!
  * 02. Weed price / $multiplier                     - COLOMBIAN FREIGHTER DUSTED THE COAST GUARD !!  WEED PRICES HAVE BOTTOMED OUT !!
  * 03. Game date + X days                           - POLICE DOGS CHASE YOU FOR X BLOCKS 
  * 04. -1 to -10 units of drugs from every category - YOU DROPPED SOME DRUGS !!  THAT\'S A DRAG MAN !!
  * 05. -1 to -20 units of weed                      - YOUR MAMA MADE SOME BROWNIES AND USED YOUR WEED !! THEY WERE GREAT !! 
  * 06. Heroin price / $multiplier                   - PIGS ARE SELLING CHEAP HEROIN FROM LAST WEEKS RAID !!
  * 07. Adds 1 to 10 units of a single drug          - YOU FIND '.$findHowMany.' UNITS OF '.$findWhat.' ON A DEAD DUDE IN THE SUBWAY !!
  * 08. Ludes price / $multiplier                    - RIVAL DRUG DEALERS RADED A PHARMACY AND ARE SELLING  C H E A P   L U D E S !!!
  * 09. Heroin price * $multiplier                   - ADDICTS ARE BUYING HEROIN AT OURAGEOUS PRICES !!
  * 10. Acid price / $multiplier                     - THE MARKET HAS BEEN FLOODED WITH CHEAP HOME MADE ACID !!!
  * 11. User cash / $multiplier                      - YOU WERE MUGGED IN THE SUBWAY !!
  *
  * Special encounters (requiring extra action)
  *
  * 12. Adds 10 to 25 units of coat space            - DO YOU WANT TO BUY A NEW COAT FOR '.($coatSpace + 100).' ?
  * 13. 50% for death, 50% for +1 points multiplier  - THERE IS SOME WEED THAT SMELLS LIKE PARAQUAT HERE !! IT LOOKS GOOD !! WILL YOU SMOKE IT ?
  * 14. Buy a weapon for 300-500 to fight the cops   - WILL YOU BUY A .38 SPECIAL FOR XXX ?
  * 15. Fight 1 to 6 cops                            - OFFICER HARDASS AND X OF HIS DEPUTIES ARE CHASING YOU !!!!!
  */

  public static function random_encounter() {

    $dice = mt_rand(1,20);
    $multiplier = mt_rand(2,10);

    switch($dice) {
      case 1:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_01'));
        Session::set('price_product_1', Session::get('price_product_1') * $multiplier);
      break;

      case 2:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_02'));
        Session::set('price_product_4', floor(Session::get('price_product_4') / $multiplier));
      break;

      case 3:
        $daysLost = mt_rand(1,3);
        Session::add('feedback_negative', str_replace('[daysLost]',$daysLost,Options::get('TXT_RAND_ENCOUNTER_03')));
        Session::set('game_date', strtotime('+'.$daysLost.' day', Session::get('game_date')));
      break;

      case 4:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_04'));

        // mt_rand runs every time so it can get the different number for each drugs
        $drugsDropped = mt_rand(1,10);
        // remove dropped drugs
        Session::set('coat_product_1', Session::get('coat_product_1') - $drugsDropped);
        // if there's more drugs dropped than the player possess
        if(Session::get('coat_product_1') < 0) {
          // get a new value of dropped drugs (above 0)
          $drugsDropped = $drugsDropped + Session::get('coat_product_1');
          // add space to the coat
          Session::set('hold', Session::get('hold') + $drugsDropped);
          // set drug quantity to zero
          Session::set('coat_product_1', 0);
        }

        // if there are still drugs left
        else {
          // add space to the coat
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        // it's basically the same for all the other drugs, need to be changed
        // can be automated better

        $drugsDropped = mt_rand(1,10);
        Session::set('coat_product_2', Session::get('coat_product_2') - $drugsDropped);
        if(Session::get('coat_product_2') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_product_2');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_product_2', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);        
        Session::set('coat_product_3', Session::get('coat_product_3') - $drugsDropped);
        if(Session::get('coat_product_3') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_product_3');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_product_3', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);        
        Session::set('coat_product_4', Session::get('coat_product_4') - $drugsDropped);
        if(Session::get('coat_product_4') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_product_4');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_product_4', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);        
        Session::set('coat_product_5', Session::get('coat_product_5') - $drugsDropped);
        if(Session::get('coat_product_5') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_product_5');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_product_5', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);        
        Session::set('coat_product_6', Session::get('coat_product_6') - $drugsDropped);
        if(Session::get('coat_product_6') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_product_6');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_product_6', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }
      break;

      case 5:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_05'));
        $weedLost = mt_rand(1,20);
        Session::set('coat_product_4', Session::get('coat_product_4') - $weedLost);
        // if the quantity of weed dropped below zero
        if(Session::get('coat_product_4') < 0) {
          $weedLost = $weedLost + Session::get('coat_product_4');
          Session::set('hold', Session::get('hold') + $weedLost);
          Session::set('coat_product_4', 0);
        } else {
          Session::set('hold', Session::get('hold') + $weedLost);
        }
      break;

      case 6:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_06'));
        Session::set('price_product_2', floor(Session::get('price_product_2') / $multiplier));
      break;

      case 7:
        $findHowMany = mt_rand(1,10);
        // if there's not enough space in the coat for the drugs that were found
        if((Session::get('hold') - $findHowMany) < 0) {
          $findHowMany = Session::get('hold');
        }

        $findWhat = mt_rand(1,6);
        switch($findWhat) {

          // kokaina
          case 1:
            Session::set('coat_product_1', Session::get('coat_product_1') + $findHowMany);
            $findWhat = Options::get('PRODUCT_1');
          break;

          // heroina
          case 2:
            Session::set('coat_product_2', Session::get('coat_product_2') + $findHowMany);
            $findWhat = Options::get('PRODUCT_2');
          break;

          // acid
          case 3:
            Session::set('coat_product_3', Session::get('coat_product_3') + $findHowMany);
            $findWhat = Options::get('PRODUCT_3');
          break;

          // weed
          case 4:
            Session::set('coat_product_4', Session::get('coat_product_4') + $findHowMany);
            $findWhat = Options::get('PRODUCT_4');
          break;

          // speed
          case 5:
            Session::set('coat_product_5', Session::get('coat_product_5') + $findHowMany);
            $findWhat = Options::get('PRODUCT_5');
          break;

          // ludes
          case 6:
            Session::set('coat_product_6', Session::get('coat_product_6') + $findHowMany);
            $findWhat = Options::get('PRODUCT_6');
          break;

        }
        // remove space from the coat
        Session::set('hold', Session::get('hold') - $findHowMany);
        Session::add('feedback_negative', str_replace('[findWhat]',$findWhat,(str_replace('[findHowMany]',$findHowMany,Options::get('TXT_RAND_ENCOUNTER_07')))));
      break;

      case 8:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_08'));
        Session::set('price_product_6', floor(Session::get('price_product_6') / $multiplier));
      break;

      case 9:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_09'));
        Session::set('price_product_2', Session::get('price_product_2') * $multiplier);
      break;

      case 10:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_10'));
        Session::set('price_product_3', floor(Session::get('price_product_3') / $multiplier));
      break;

      case 11:
        Session::add('feedback_negative', Options::get('TXT_RAND_ENCOUNTER_11'));
        Session::set('cash', floor(Session::get('cash') / $multiplier));
      break;

      case 12:
        $coatSpace = mt_rand(10,25);
        // Session::add('feedback_negative', 'DO YOU WANT TO BUY A NEW COAT FOR '.($coatSpace + 100).' ?'); (currently in view/action_menu_2.php)
        Session::set('user_action', 12);
        Session::set('user_coat_price', 100+$coatSpace);
      break;

      case 13:
        // Session::add('feedback_negative', 'THERE IS SOME WEED THAT SMELLS LIKE PARAQUAT HERE !! IT LOOKS GOOD !!<br>WILL YOU SMOKE IT ?'); (currently in view/action_menu_2.php)
        Session::set('user_action', 13);
      break;

      case 14:
        // Session::add('feedback_negative', 'WILL YOU BUY A .38 SPECIAL FOR XXX ?'); (currently in view/action_menu_2.php)
        Session::set('user_action', 14);
        Session::set('user_gun_price', mt_rand(300,500));
      break;

      default:
        // Session::add('feedback_negative', 'OFFICER HARDASS AND X OF HIS DEPUTIES ARE CHASING YOU !!!!!'); (currently in view/action_menu_2.php)
        // set the numbers of cops
        Session::set('cops',mt_rand(1,5));
        Session::set('cops_total', Session::get('cops'));
        Session::set('user_action', 30);
      break;
    }

    return true;

  }


  /*
  * Action. This method is responsible for handling user input required by some encounters.
  * It sets the user_action var, which blocks the rendering of default action menu and shows
  * the action_menu_2.php instead (check GameController.php for more info).
  *
  * Available actions (starts with action id):
  *
  * 12. Buy new coat (adds more space)
  * 13. Paraquat smelling weed (50% for death, 50% for points multiplier)
  * 14. Buy new gun (adds one gun to the inventory)
  * 30. Fight officer hardass - start screen
  * 31. Fight officer hardass - actual fight
  * 32. Fight officer hardass - end of the fight, summary
  */

  public static function action() {

    // get action id
    $actionId = Session::get('user_action');

    switch($actionId) {

      // Buy new coat
      case 12:
        if(Request::post('action') == 'yes') {

          // check if the player can afford it
          if($_SESSION['user_coat_price'] > Session::get('cash')) {
            Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
          } else {
            // remove cash from the player
            Session::set('cash', Session::get('cash') - $_SESSION['user_coat_price']);
            // add more space to the coat
            Session::set('hold', Session::get('hold') + ($_SESSION['user_coat_price']-100));

          }
        }
      break;

      // Paraquat smelling weed
      case 13:
        if(Request::post('action') == 'yes') {
          // 50% for death, 50% for points multiplier
          $deathRoll = mt_rand(1,2);
          if($deathRoll == 1) {
            Session::add('feedback_negative', 'YOU HALUCINATE FOR THREE DAYS ON THE WILDEST TRIP YOU EVER IMAGINED !!!<br>THEN YOU DIE BECAUSE YOUR BRAIN HAS DISINTEGRATED !!!');
            Session::set('game_date', strtotime('1-2-1984'));
          } else {
            Session::add('feedback_negative', 'YOU FEEL MORE POWERFUL !!!');
          }
        }
      break;

      // buy new gun
      case 14:
        if(Request::post('action') == 'yes') {

          // check if the player can afford it
          if($_SESSION['user_gun_price'] > Session::get('cash')) {
            Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
          } else {
            // remove cash from the player
            Session::set('cash', Session::get('cash') - $_SESSION['user_gun_price']);
            // add gun to the user inventory
            Session::set('guns', Session::get('guns') + 1);
          }
        }
      break;

      // Fight officer hardass - start screen
      case 30:
        // set the user_action to actual fight (31)
        Session::set('user_action', 31);
        return true;
      break;

      // Fight officer hardass - actual fight
      case 31:

        // If the player is out of hp (end of the game)
        if(Session::get('user_hp') >= 50) {
          Session::add('feedback_negative', 'THEY KILLED YOU !!!!');
          Session::set('game_date', strtotime('1-2-1984'));
          return true;
        }

        // player tries to run
        if(Request::post('action') == 'run') {

          // 40% chance for succesfull escape
          $diceRoll = mt_rand(1,100);

          // escape is not succesfull
          if($diceRoll <= 60) {

            // cops are trying to shot you
            Session::add('feedback_negative', 'THEY ARE FIRING ON YOU MAN !!');

            // 80% chance for hit
            $diceRoll = mt_rand(1,100);
            
            if($diceRoll <= 80) {
              Session::add('feedback_negative', 'YOU\'VE BEEN HIT !!');
              // set the damage
              $damage = mt_rand(1,5);
              Session::set('user_hp', Session::get('user_hp') + $damage);
            }

            // return true so the user_action isn't unset at the end of this method
            return true;
          }

        }

        // player tries to fight
        elseif(Request::post('action') == 'fight') {

          // 50% for a hit
          $diceRoll = mt_rand(1,100);
          if($diceRoll <= 50) {

            // remove one enemy
            Session::set('cops', Session::get('cops') - 1);

            // if the player kills all the cops and wins the fight
            if(Session::get('cops') <= 0) {

              Session::add('feedback_negative', 'YOU KILLED ALL '.Session::get('cops_total').' OF THEM !!!!');

              // looted cash
              $extraCash = mt_rand(500, 2000 * Session::get('cops_total'));
              Session::set('cash', Session::get('cash') + $extraCash);
              Session::add('feedback_negative', 'YOU FOUND '.$extraCash.' DOLLARS ON OFFICER HARDASS\' CARCASS !!!');

              // sets the user_action to 32 (summary of the fight) and returns true so the user_action var isn't unset
              Session::set('user_action', 32);
              return true;

            }

            // info about the shoting
            Session::add('feedback_negative', 'YOU\'RE FIRING ON THEM !!!');
            Session::add('feedback_negative', 'YOU KILLED ONE !!');

          }

          // Cops are firing on the player
          Session::add('feedback_negative', 'THEY ARE FIRING ON YOU MAN !!');

          // 50% chances for a hit
          $diceRoll = mt_rand(1,100);

          // player got hit
          if($diceRoll <= 50) {
            Session::add('feedback_negative', 'YOU\'VE BEEN HIT !!');
            // set the damage and add it to user_hp
            $damage = mt_rand(1,5);
            Session::set('user_hp', Session::get('user_hp') + $damage);
          } else {
            Session::add('feedback_negative', 'THEY\'VE MISSED !!');
          }

          // return true so the user_action var isn't unset
          return true;

        }

      break;

    }

    unset($_SESSION['user_action']);
    unset($_SESSION['user_coat_price']);
    unset($_SESSION['user_gun_price']);

    return true;

  }


  /*
  * Repay
  * 
  * Repays the loan shark debt.
  */

  public static function repay() {

    // validate the input
    if(!is_numeric(Request::post('how_much_repay')) || Request::post('how_much_repay') < 0) {
      return false;
    }

    // check if the player can afford this
    if(Request::post('how_much_repay') > Session::get('cash')) {
      Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
      return false;
    }

    // remove cash from player
    Session::set('cash', Session::get('cash') - floor(Request::post('how_much_repay')));
    // set the new debt
    Session::set('debt', Session::get('debt') - floor(Request::post('how_much_repay')));
    // if the new debt goes below zero, don't let this happen
    if(Session::get('debt') < 0) { Session::set('debt', 0); }

    return true;

  }


  /*
  * Borrow
  * 
  * Borrow the money from the loan shark and create new debt.
  */

  public static function borrow() {

    // validate
    if(!is_numeric(Request::post('how_much_borrow')) || Request::post('how_much_borrow') < 0) {
      return false;
    }

    // check if the new debt isn't above the limit
    if(Request::post('how_much_borrow') + Session::get('debt') >= 13000) {
      Session::add('feedback_negative', 'YOU CAN\'T BORROW THAT MUCH !');
      return false;
    }

    // add cash to players inventory
    Session::set('cash', Session::get('cash') + floor(Request::post('how_much_borrow')));
    // set new debt
    Session::set('debt', Session::get('debt') + floor(Request::post('how_much_borrow')));

    return true;

  }


  /*
  * Transfer drugs
  * 
  * Transfer drugs between coat and stash.
  */

  public static function transfer_drugs() {

    // find out which drug the player wants to transfer from coat to the stash
    if    (Request::post('stash_product_1') != null) { $transferToStash[] = 'product_1'; }
    elseif(Request::post('stash_product_2') != null) { $transferToStash[] = 'product_2'; }
    elseif(Request::post('stash_product_3') != null) { $transferToStash[] = 'product_3'; }
    elseif(Request::post('stash_product_4') != null) { $transferToStash[] = 'product_4'; }
    elseif(Request::post('stash_product_5') != null) { $transferToStash[] = 'product_5'; }
    elseif(Request::post('stash_product_6') != null) { $transferToStash[] = 'product_6'; }
    else { $transferToStash = null; }

    // find out which drug the player wants to transfer from stash to the coat
    if    (Request::post('coat_product_1') != null) { $transferToCoat[] = 'product_1'; }
    elseif(Request::post('coat_product_2') != null) { $transferToCoat[] = 'product_2'; }
    elseif(Request::post('coat_product_3') != null) { $transferToCoat[] = 'product_3'; }
    elseif(Request::post('coat_product_4') != null) { $transferToCoat[] = 'product_4'; }
    elseif(Request::post('coat_product_5') != null) { $transferToCoat[] = 'product_5'; }
    elseif(Request::post('coat_product_6') != null) { $transferToCoat[] = 'product_6'; }
    else { $transferToCoat = null; }

    // if the player wants to transfer something to the stash
    if($transferToStash != null) {

      foreach($transferToStash as $drug) {

        if(Request::post('stash_'.$drug) && Request::post('stash_'.$drug) > 0 && is_numeric(Request::post('stash_'.$drug))) {
          // check if there's enough merchandise to transfer
          if(Request::post('stash_'.$drug) > Session::get('coat_'.$drug)) {
            Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH '.(Options::get(strtoupper($drug))).' ON YOU !');
            return false;
          }
          // add new merchandise to 'the stash'
          Session::set('stash_'.$drug, Session::get('stash_'.$drug) + Request::post('stash_'.$drug));
          // remove merchandise from 'the coat'
          Session::set('coat_'.$drug, Session::get('coat_'.$drug) - Request::post('stash_'.$drug));
          // add space to the coat
          Session::set('hold', Session::get('hold') + Request::post('stash_'.$drug));
        }

      }

    }

    // if the player wants to transfer something from the stash to the coat
    if($transferToCoat != null) {

      foreach($transferToCoat as $drug) {

        if(Request::post('coat_'.$drug) && Request::post('coat_'.$drug) > 0 && is_numeric(Request::post('coat_'.$drug))) {
          // check if there's enough merchandise to transfer
          if(Request::post('coat_'.$drug) > Session::get('stash_'.$drug)) {
            Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH '.(Options::get(strtoupper($drug))).' IN YOUR STASH !');
            return false;
          }
          // add new merchandise to 'the coat'
          Session::set('coat_'.$drug, Session::get('coat_'.$drug) + Request::post('coat_'.$drug));
          // remove space from the coat
          Session::set('hold', Session::get('hold') - Request::post('coat_'.$drug));
          // remove merchandise from the stash
          Session::set('stash_'.$drug, Session::get('stash_'.$drug) - Request::post('coat_'.$drug));
        }

      }

    }

    return true;

  }


  /*
  * Deposit money
  * 
  * Deposit money on your bank account.
  */

  public static function deposit() {

    // validate
    if(!is_numeric(Request::post('how_much_deposit')) || Request::post('how_much_deposit') < 0) {
      return false;
    }

    // check if the player has enough cash to deposit
    if(Request::post('how_much_deposit') > Session::get('cash')) {
      Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
      return false;
    }

    // remove cash from the coat
    Session::set('cash', Session::get('cash') - Request::post('how_much_deposit'));
    // deposit cash onto players bank account
    Session::set('bank', Session::get('bank') + Request::post('how_much_deposit'));

    return true;

  }


  /*
  * Withdraw money
  * 
  * Withdraw money from your bank account.
  */

  public static function withdraw() {

    // validate
    if(!is_numeric(Request::post('how_much_withdraw')) || Request::post('how_much_withdraw') < 0) {
      return false;
    }

    // check if the player has enough cash to withdraw
    if(Request::post('how_much_withdraw') > Session::get('bank')) {
      Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
      return false;
    }

    // remove cash from the bank account
    Session::set('bank', Session::get('bank') - Request::post('how_much_withdraw'));
    // add cash to the coat
    Session::set('cash', Session::get('cash') + Request::post('how_much_withdraw'));

    return true;

  }


  /*
  * Update ranking
  * 
  * Add user score to the ranking.
  */

  public static function update_ranking() {

    // connect to the database
    $database = DatabaseFactory::getFactory()->getConnection();

    // set the variables (sum of points and players name)
    $points = Session::get('cash') + Session::get('bank') - Session::get('debt');
    $name = Request::post('player_name', true);

    // validate name
    if(strlen($name) <= 1) {
      Session::add('feedback_negative', 'NAME IS TOO SHORT (MIN. 2 CHARS)');
      return false;
    }

    if(strlen($name) > 32) {
      Session::add('feedback_negative', 'NAME IS TOO LONG (MAX. 32 CHARS)');
      return false;
    }

    if (!preg_match('/^[a-zA-Z0-9]{2,64}$/', $name)) {
      Session::add('feedback_negative', 'NAME MUST CONTAIN LETTERS AND NUMBERS ONLY');
			return false;
    }

    // save the score to the database
		$sql = "INSERT INTO ranking (id, name, points, date)
                    VALUES (:id, :name, :points, :date)";
		$query = $database->prepare($sql);
		$query->execute(array(':id' => null,
		                      ':name' => $name,
		                      ':points' => $points,
		                      ':date' => time()));

		$count =  $query->rowCount();

    // if everything is ok,  set the 'game' var to end_screen
		if ($count == 1) {
      // zmien tryb gry
      Session::set('game','end_screen');
      Session::set('user_name',$name);
			return true;
		}

		return false;

  }


  /*
  * Get the ranking
  */

  public static function get_ranking() {

    $database = DatabaseFactory::getFactory()->getConnection();

    if($database != false) {

    $sql = "SELECT *
            FROM ranking
            ORDER BY points DESC;";

    $query = $database->prepare($sql);
    $query->execute();

    return $query->fetchAll();

    }

  }

}
