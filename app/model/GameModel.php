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
  * Set all other stats, set drugs prices
  * All game variables are stored in session 
  */

  public static function start_new_game() {
    Session::set('game', 'on');
    Session::set('game_date', strtotime('4-12-1983'));
    Session::set('user_location', 'BRONX');
    Session::set('user_action', null);

    Session::set('stash_cocaine', 0);
    Session::set('stash_heroin', 0);
    Session::set('stash_acid', 0);
    Session::set('stash_weed', 0);
    Session::set('stash_speed', 0);
    Session::set('stash_ludes', 0);

    Session::set('coat_cocaine', 0);
    Session::set('coat_heroin', 0);
    Session::set('coat_acid', 0);
    Session::set('coat_weed', 0);
    Session::set('coat_speed', 0);
    Session::set('coat_ludes', 0);

    GameModel::reroll_drugs_prices();

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
  * Re-rolls drugs prices. To be changed, prices should be
  * taken from separate options file.
  */

  public static function reroll_drugs_prices() {
    Session::set('price_cocaine', mt_rand(15000, 30000));
    Session::set('price_heroin',  mt_rand(5000,  14000));
    Session::set('price_acid',    mt_rand(1000,  4500));
    Session::set('price_weed',    mt_rand(300,   900));
    Session::set('price_speed',   mt_rand(70,    250));
    Session::set('price_ludes',   mt_rand(10,    60));
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
        $location = 'BRONX';
        break;
      case 2:
        $location = 'GHETTO';
        break;
      case 3:
        $location = 'CENTRAL PARK';
        break;
      case 4:
        $location = 'MANHATTAN';
        break;
      case 5:
        $location = 'CONEY ISLAND';
        break;
      case 6:
        $location = 'BROOKLYN';
        break;
    }

    Session::set('user_location', $location);

    // 3. Add 10% debt interests if any
    GameModel::add_debt_interests();

    // 4. Add 1 day to game_date and check if it didn't hit the game limit (end of the game)
    Session::set('game_date', strtotime('+1 day', Session::get('game_date')));

    if(Session::get('game_date') > Config::get('END_GAME_DATE')) {
      Redirect::to('game/final_score/');
      return false;
    }

    // 5. Re-roll drugs prices
    GameModel::reroll_drugs_prices();

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
        $item_price = Session::get('price_cocaine');
        break;
      case 2:
        $item_name = 'HEROIN';
        $item_price = Session::get('price_heroin');
        break;
      case 3:
        $item_name = 'ACID';
        $item_price = Session::get('price_acid');
        break;
      case 4:
        $item_name = 'WEED';
        $item_price = Session::get('price_weed');
        break;
      case 5:
        $item_name = 'SPEED';
        $item_price = Session::get('price_speed');
        break;
      case 6:
        $item_name = 'LUDES';
        $item_price = Session::get('price_ludes');
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
        Session::set('coat_cocaine', Session::get('coat_cocaine') + Request::post('quantity'));
        break;
      case 2:
        Session::set('coat_heroin', Session::get('coat_heroin') + Request::post('quantity'));
        break;
      case 3:
        Session::set('coat_acid', Session::get('coat_acid') + Request::post('quantity'));
        break;
      case 4:
        Session::set('coat_weed', Session::get('coat_weed') + Request::post('quantity'));
        break;
      case 5:
        Session::set('coat_speed', Session::get('coat_speed') + Request::post('quantity'));
        break;
      case 6:
        Session::set('coat_ludes', Session::get('coat_ludes') + Request::post('quantity'));
        break;
    }
  }


  /*
  * Sell drugs.
  *
  * 1. Validate the input
  * 2. Check what drugs the user wants to sell and get their local prices
  * 3. Check if the user actually has the drugs for sale
  * 4. Remove drugs from the coat
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

    // 2. Check what drugs the user wants to sell and get their local prices
    switch($itemId) {
      case 1:
        $item_name = 'COCAINE';
        $item_price = Session::get('price_cocaine');
        break;
      case 2:
        $item_name = 'HEROIN';
        $item_price = Session::get('price_heroin');
        break;
      case 3:
        $item_name = 'ACID';
        $item_price = Session::get('price_acid');
        break;
      case 4:
        $item_name = 'WEED';
        $item_price = Session::get('price_weed');
        break;
      case 5:
        $item_name = 'SPEED';
        $item_price = Session::get('price_speed');
        break;
      case 6:
        $item_name = 'LUDES';
        $item_price = Session::get('price_ludes');
        break;
    }

    // 3. Check if the user actually has the drugs for sale
    if(Session::get('coat_'.strtolower($item_name)) < Request::post('quantity')) {
      Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MANY, DUDE !');
      Redirect::to('game/');
      return false;
    }

    // 4. Remove drugs from the coat
    Session::set('coat_'.strtolower($item_name), Session::get('coat_'.strtolower($item_name)) - Request::post('quantity'));

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
        Session::add('feedback_negative', 'COPS MADE A BIG COKE BUST !!  PRICES ARE OUTRAGEOUS !!');
        Session::set('price_cocaine', Session::get('price_cocaine') * $multiplier);
      break;

      case 2:
        Session::add('feedback_negative', 'COLOMBIAN FREIGHTER DUSTED THE COAST GUARD !!  WEED PRICES HAVE BOTTOMED OUT !!');
        Session::set('price_weed', floor(Session::get('price_weed') / $multiplier));
      break;

      case 3:
        $daysLost = mt_rand(1,3);
        Session::add('feedback_negative', 'POLICE DOGS CHASE YOU FOR '.$daysLost.' BLOCKS !!');
        Session::set('game_date', strtotime('+'.$daysLost.' day', Session::get('game_date')));
      break;

      case 4:
        Session::add('feedback_negative', 'YOU DROPPED SOME DRUGS !!  THAT\'S A DRAG MAN !!');

        // odpalane za kazdym razem, zeby wylosowalo nowa ilosc dragow do zgubienia
        $drugsDropped = mt_rand(1,10);
        // odjecie upuszczonych dragow
        Session::set('coat_cocaine', Session::get('coat_cocaine') - $drugsDropped);
        // jesli dragi wychodza na minus
        if(Session::get('coat_cocaine') < 0) {
          // ustalenie nowej wartosci upuszczonych dragow (powyzej 0)
          $drugsDropped = $drugsDropped + Session::get('coat_cocaine');
          // dodanie miejsca do plaszcza
          Session::set('hold', Session::get('hold') + $drugsDropped);
          // wyzerowanie ilosci kokainy
          Session::set('coat_cocaine', 0);
        }

        // jesli zostaje jeszcze troche dragow
        else {
          // dodanie miejsca do plaszcza
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);
        Session::set('coat_heroin', Session::get('coat_heroin') - $drugsDropped);
        if(Session::get('coat_heroin') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_heroin');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_heroin', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);        
        Session::set('coat_acid', Session::get('coat_acid') - $drugsDropped);
        if(Session::get('coat_acid') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_acid');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_acid', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);        
        Session::set('coat_weed', Session::get('coat_weed') - $drugsDropped);
        if(Session::get('coat_weed') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_weed');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_weed', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);        
        Session::set('coat_speed', Session::get('coat_speed') - $drugsDropped);
        if(Session::get('coat_speed') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_speed');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_speed', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }

        $drugsDropped = mt_rand(1,10);        
        Session::set('coat_ludes', Session::get('coat_ludes') - $drugsDropped);
        if(Session::get('coat_ludes') < 0) {
          $drugsDropped = $drugsDropped + Session::get('coat_ludes');
          Session::set('hold', Session::get('hold') + $drugsDropped);
          Session::set('coat_ludes', 0);
        } else {
          Session::set('hold', Session::get('hold') + $drugsDropped);
        }
      break;

      case 5:
        Session::add('feedback_negative', 'YOUR MAMA MADE SOME BROWNIES AND USED YOUR WEED !!<br>THEY WERE GREAT !!');
        $weedLost = mt_rand(1,20);
        Session::set('coat_weed', Session::get('coat_weed') - $weedLost);
        // jesli ilosc zielska spadla ponizej 0
        if(Session::get('coat_weed') < 0) {
          $weedLost = $weedLost + Session::get('coat_weed');
          Session::set('hold', Session::get('hold') + $weedLost);
          Session::set('coat_weed', 0);
        } else {
          Session::set('hold', Session::get('hold') + $weedLost);
        }
      break;

      case 6:
        Session::add('feedback_negative', 'PIGS ARE SELLING CHEAP HEROIN FROM LAST WEEKS RAID !!');
        Session::set('price_heroin', floor(Session::get('price_heroin') / $multiplier));
      break;

      case 7:
        $findHowMany = mt_rand(1,10);
        // jesli znaleziona ilosc dragow przekracza pojemnosc plaszcza
        if((Session::get('hold') - $findHowMany) < 0) {
          $findHowMany = Session::get('hold');
        }

        $findWhat = mt_rand(1,6);
        switch($findWhat) {

          // kokaina
          case 1:
            Session::set('coat_cocaine', Session::get('coat_cocaine') + $findHowMany);
            $findWhat = 'COCAINE';
          break;

          // heroina
          case 2:
            Session::set('coat_heroin', Session::get('coat_heroin') + $findHowMany);
            $findWhat = 'HEROIN';
          break;

          // acid
          case 3:
            Session::set('coat_acid', Session::get('coat_acid') + $findHowMany);
            $findWhat = 'ACID';
          break;

          // weed
          case 4:
            Session::set('coat_weed', Session::get('coat_weed') + $findHowMany);
            $findWhat = 'WEED';
          break;

          // speed
          case 5:
            Session::set('coat_speed', Session::get('coat_speed') + $findHowMany);
            $findWhat = 'SPEED';
          break;

          // ludes
          case 6:
            Session::set('coat_ludes', Session::get('coat_ludes') + $findHowMany);
            $findWhat = 'LUDES';
          break;

        }
        // odjecie miejsca z plaszcza
        Session::set('hold', Session::get('hold') - $findHowMany);
        Session::add('feedback_negative', 'YOU FIND '.$findHowMany.' UNITS OF '.$findWhat.' ON A DEAD DUDE IN THE SUBWAY !!');
      break;

      case 8:
        Session::add('feedback_negative', 'RIVAL DRUG DEALERS RADED A PHARMACY AND ARE SELLING  C H E A P   L U D E S !!!');
        Session::set('price_ludes', floor(Session::get('price_ludes') / $multiplier));
      break;

      case 9:
        Session::add('feedback_negative', 'ADDICTS ARE BUYING HEROIN AT OURAGEOUS PRICES !!');
        Session::set('price_heroin', Session::get('price_heroin') * $multiplier);
      break;

      case 10:
        Session::add('feedback_negative', 'THE MARKET HAS BEEN FLOODED WITH CHEAP HOME MADE ACID !!!');
        Session::set('price_acid', floor(Session::get('price_acid') / $multiplier));
      break;

      case 11:
        Session::add('feedback_negative', 'YOU WERE MUGGED IN THE SUBWAY !!');
        Session::set('cash', floor(Session::get('cash') / $multiplier));
      break;

      case 12:
        $coatSpace = mt_rand(10,25);
        // Session::add('feedback_negative', 'DO YOU WANT TO BUY A NEW COAT FOR '.($coatSpace + 100).' ?'); (chwilowo w widoku)
        Session::set('user_action', 12);
        Session::set('user_coat_price', 100+$coatSpace);
      break;

      case 13:
        // Session::add('feedback_negative', 'THERE IS SOME WEED THAT SMELLS LIKE PARAQUAT HERE !! IT LOOKS GOOD !!<br>WILL YOU SMOKE IT ?'); (chwilowo w widoku)
        Session::set('user_action', 13);
      break;

      case 14:
        // Session::add('feedback_negative', 'WILL YOU BUY A .38 SPECIAL FOR XXX ?'); (chwilowo w widoku)
        Session::set('user_action', 14);
        Session::set('user_gun_price', mt_rand(300,500));
      break;

      default:
        // Session::add('feedback_negative', 'OFFICER HARDASS AND X OF HIS DEPUTIES ARE CHASING YOU !!!!!'); (chwilowo w widoku)
        // wylosowanie ilosci gliniarzy
        Session::set('cops',mt_rand(1,5));
        Session::set('cops_total', Session::get('cops'));
        Session::set('user_action', 30);
      break;
    }

    return true;

  }

  // akcja z random encounter
  public static function action() {

    // id akcji
    $actionId = Session::get('user_action');

    switch($actionId) {

      // kupno nowego plaszcza
      case 12:
        if(Request::post('action') == 'yes') {

          // sprawdzenie czy gracza na to stac
          if($_SESSION['user_coat_price'] > Session::get('cash')) {
            Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
          } else {

            // odjecie kasy z plaszcza
            Session::set('cash', Session::get('cash') - $_SESSION['user_coat_price']);
            // dodanie miejsca do plaszcza
            Session::set('hold', Session::get('hold') + ($_SESSION['user_coat_price']-100));

          }
        }
      break;

      // super joint
      case 13:
        if(Request::post('action') == 'yes') {
          // 50% na zgon, 50% na podwojenie pkt
          $deathRoll = mt_rand(1,2);
          if($deathRoll == 1) {
            Session::add('feedback_negative', 'YOU HALUCINATE FOR THREE DAYS ON THE WILDEST TRIP YOU EVER IMAGINED !!!<br>THEN YOU DIE BECAUSE YOUR BRAIN HAS DISINTEGRATED !!!');
            Session::set('game_date', strtotime('1-2-1984'));
          } else {
            Session::add('feedback_negative', 'YOU FEEL MORE POWERFUL !!!');
          }
        }
      break;

      // kupno nowej broni
      case 14:
        if(Request::post('action') == 'yes') {

          // sprawdzenie czy gracza na to stac
          if($_SESSION['user_gun_price'] > Session::get('cash')) {
            Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
          } else {

            // odjecie kasy z plaszcza
            Session::set('cash', Session::get('cash') - $_SESSION['user_gun_price']);
            // dodanie broni do plaszcza
            Session::set('guns', Session::get('guns') + 1);
            
          }
        }
      break;

      // officer hardass - poczatek
      case 30:
        // ustawienie akcji na walke z policjantem
        Session::set('user_action', 31);
        return true;
      break;

      // officer hardass - walka
      case 31:

        // jesli skonczyly sie hp...
        if(Session::get('user_hp') >= 50) {
          Session::add('feedback_negative', 'THEY KILLED YOU !!!!');
          Session::set('game_date', strtotime('1-2-1984'));
          return true;
        }

        // proba ucieczki
        if(Request::post('action') == 'run') {

          // 40% szans na ucieczke
          $diceRoll = mt_rand(1,100);

          // ucieczka sie nie powiodla
          if($diceRoll <= 60) {

            // info o tym ze strzelaja i nie da sie uciekac
            Session::add('feedback_negative', 'THEY ARE FIRING ON YOU MAN !!');

            // 80% szans na to ze trafili
            $diceRoll = mt_rand(1,100);
            
            if($diceRoll <= 80) {
              // info o tym ze sie dostalo
              Session::add('feedback_negative', 'YOU\'VE BEEN HIT !!');
              // wylosowanie zadanych przez gliniarzy obrazen
              $damage = mt_rand(1,5);
              Session::set('user_hp', Session::get('user_hp') + $damage);
            }

            return true;
          }

        }

        // proba walki
        elseif(Request::post('action') == 'fight') {

          // 50% na trafienie przeciwnika
          $diceRoll = mt_rand(1,100);
          if($diceRoll <= 50) {

            Session::set('cops', Session::get('cops') - 1);

            // jesli pokonalo sie wszystkich, koniec walki
            if(Session::get('cops') <= 0) {

              Session::add('feedback_negative', 'YOU KILLED ALL '.Session::get('cops_total').' OF THEM !!!!');

              // znaleziona przy trupach kasa
              $extraCash = mt_rand(500, 2000 * Session::get('cops_total'));
              Session::set('cash', Session::get('cash') + $extraCash);
              Session::add('feedback_negative', 'YOU FOUND '.$extraCash.' DOLLARS ON OFFICER HARDASS\' CARCASS !!!');

              Session::set('user_action', 32);
              return true;

            }

            Session::add('feedback_negative', 'YOU\'RE FIRING ON THEM !!!');
            Session::add('feedback_negative', 'YOU KILLED ONE !!');

          }

          // info o tym ze strzelaja i nie da sie uciekac
          Session::add('feedback_negative', 'THEY ARE FIRING ON YOU MAN !!');

          // 50% szans na to ze trafili
          $diceRoll = mt_rand(1,100);
          
          if($diceRoll <= 50) {
            // info o tym ze sie dostalo
            Session::add('feedback_negative', 'YOU\'VE BEEN HIT !!');
            // wylosowanie zadanych przez gliniarzy obrazen
            $damage = mt_rand(1,5);
            Session::set('user_hp', Session::get('user_hp') + $damage);
          } else {
            Session::add('feedback_negative', 'THEY\'VE MISSED !!');
          }

          return true;

        }

      break;

    }

    unset($_SESSION['user_action']);
    unset($_SESSION['user_coat_price']);
    unset($_SESSION['user_gun_price']);

    return true;

  }

  // splacanie dlugu
  public static function repay() {

    // walidacja
    if(!is_numeric(Request::post('how_much_repay')) || Request::post('how_much_repay') < 0) {
      return false;
    }

    // sprawdzenie czy go na to stac
    if(Request::post('how_much_repay') > Session::get('cash')) {
      Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
      return false;
    }

    // odjecie kasy z plaszcza
    Session::set('cash', Session::get('cash') - floor(Request::post('how_much_repay')));
    // odjecie dlugu od lichwiarza
    Session::set('debt', Session::get('debt') - floor(Request::post('how_much_repay')));
    // jesli dlug mniejszy niz 0 ustaw go na 0
    if(Session::get('debt') < 0) { Session::set('debt', 0); }

    return true;

  }

  // nowy dlug
  public static function borrow() {

    // walidacja
    if(!is_numeric(Request::post('how_much_borrow')) || Request::post('how_much_borrow') < 0) {
      return false;
    }

    // czy nie przekracza limitu
    if(Request::post('how_much_borrow') + Session::get('debt') >= 13000) {
      Session::add('feedback_negative', 'YOU CAN\'T BORROW THAT MUCH !');
      return false;
    }

    // dodanie kasy do plaszcza
    Session::set('cash', Session::get('cash') + floor(Request::post('how_much_borrow')));
    // dodanie dlugu do lichwiarza
    Session::set('debt', Session::get('debt') + floor(Request::post('how_much_borrow')));

    return true;

  }

  // transfer dragow
  public static function transfer_drugs() {

    // transfer kokainy z plaszcza do skrytyki
    if(Request::post('stash_cocaine') && Request::post('stash_cocaine') > 0 && is_numeric(Request::post('stash_cocaine'))) {
      // sprawdzenie czy kokaina jest
      if(Request::post('stash_cocaine') > Session::get('coat_cocaine')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH COCAINE ON YOU !');
        return false;
      }
      // dodanie kokainy do skrytki
      Session::set('stash_cocaine', Session::get('stash_cocaine') + Request::post('stash_cocaine'));
      // odjecie kokainy z plaszcza
      Session::set('coat_cocaine', Session::get('coat_cocaine') - Request::post('stash_cocaine'));
      // dodanie miejsca do plaszcza
      Session::set('hold', Session::get('hold') + Request::post('stash_cocaine'));
    }

    // transfer kokainy ze skrytki do plaszcza
    if(Request::post('trench_cocaine') && Request::post('trench_cocaine') > 0 && is_numeric(Request::post('trench_cocaine'))) {
      // sprawdzenie czy kokaina jest
      if(Request::post('trench_cocaine') > Session::get('stash_cocaine')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH COCAINE IN YOUR STASH !');
        return false;
      }
      // dodanie kokainy do plaszcza
      Session::set('coat_cocaine', Session::get('coat_cocaine') + Request::post('trench_cocaine'));
      // odjecie miejsca z plaszcza
      Session::set('hold', Session::get('hold') - Request::post('trench_cocaine'));
      // odjecie kokainy ze skrytki
      Session::set('stash_cocaine', Session::get('stash_cocaine') - Request::post('trench_cocaine'));
    }


    // transfer heroiny z plaszcza do skrytyki
    if(Request::post('stash_heroin') && Request::post('stash_heroin') > 0 && is_numeric(Request::post('stash_heroin'))) {
      // sprawdzenie czy kokaina jest
      if(Request::post('stash_heroin') > Session::get('coat_heroin')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH HEROIN ON YOU !');
        return false;
      }
      // dodanie heroiny do skrytki
      Session::set('stash_heroin', Session::get('stash_heroin') + Request::post('stash_heroin'));
      // odjecie heroiny z plaszcza
      Session::set('coat_heroin', Session::get('coat_heroin') - Request::post('stash_heroin'));
      // dodanie miejsca do plaszcza
      Session::set('hold', Session::get('hold') + Request::post('stash_heroin'));
    }

    // transfer heroiny ze skrytki do plaszcza
    if(Request::post('trench_heroin') && Request::post('trench_heroin') > 0 && is_numeric(Request::post('trench_heroin'))) {
      // sprawdzenie czy kokaina jest
      if(Request::post('trench_heroin') > Session::get('stash_heroin')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH HEROIN IN YOUR STASH !');
        return false;
      }
      // dodanie heroiny do plaszcza
      Session::set('coat_heroin', Session::get('coat_heroin') + Request::post('trench_heroin'));
      // odjecie miejsca z plaszcza
      Session::set('hold', Session::get('hold') - Request::post('trench_heroin'));
      // odjecie heroiny ze skrytki
      Session::set('stash_heroin', Session::get('stash_heroin') - Request::post('trench_heroin'));
    }


    // transfer acida z plaszcza do skrytyki
    if(Request::post('stash_acid') && Request::post('stash_acid') > 0 && is_numeric(Request::post('stash_acid'))) {
      // sprawdzenie czy acid jest
      if(Request::post('stash_acid') > Session::get('coat_acid')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH ACID ON YOU !');
        return false;
      }
      // dodanie acida do skrytki
      Session::set('stash_acid', Session::get('stash_acid') + Request::post('stash_acid'));
      // odjecie acida z plaszcza
      Session::set('coat_acid', Session::get('coat_acid') - Request::post('stash_acid'));
      // dodanie miejsca do plaszcza
      Session::set('hold', Session::get('hold') + Request::post('stash_acid'));
    }

    // transfer acida ze skrytki do plaszcza
    if(Request::post('trench_acid') && Request::post('trench_acid') > 0 && is_numeric(Request::post('trench_acid'))) {
      // sprawdzenie czy kokaina jest
      if(Request::post('trench_acid') > Session::get('stash_acid')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH ACID IN YOUR STASH !');
        return false;
      }
      // dodanie acida do plaszcza
      Session::set('coat_acid', Session::get('coat_acid') + Request::post('trench_acid'));
      // odjecie miejsca z plaszcza
      Session::set('hold', Session::get('hold') - Request::post('trench_acid'));
      // odjecie acida ze skrytki
      Session::set('stash_acid', Session::get('stash_acid') - Request::post('trench_acid'));
    }


    // transfer weed z plaszcza do skrytyki
    if(Request::post('stash_weed') && Request::post('stash_weed') > 0 && is_numeric(Request::post('stash_weed'))) {
      // sprawdzenie czy weed jest
      if(Request::post('stash_weed') > Session::get('coat_weed')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH WEED ON YOU !');
        return false;
      }
      // dodanie weeda do skrytki
      Session::set('stash_weed', Session::get('stash_weed') + Request::post('stash_weed'));
      // odjecie weeda z plaszcza
      Session::set('coat_weed', Session::get('coat_weed') - Request::post('stash_weed'));
      // dodanie miejsca do plaszcza
      Session::set('hold', Session::get('hold') + Request::post('stash_weed'));
    }

    // transfer weeda ze skrytki do plaszcza
    if(Request::post('trench_weed') && Request::post('trench_weed') > 0 && is_numeric(Request::post('trench_weed'))) {
      // sprawdzenie czy kokaina jest
      if(Request::post('trench_weed') > Session::get('stash_weed')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH WEED IN YOUR STASH !');
        return false;
      }
      // dodanie weeda do plaszcza
      Session::set('coat_weed', Session::get('coat_weed') + Request::post('trench_weed'));
      // odjecie miejsca z plaszcza
      Session::set('hold', Session::get('hold') - Request::post('trench_weed'));
      // odjecie weeda ze skrytki
      Session::set('stash_weed', Session::get('stash_weed') - Request::post('trench_weed'));
    }


    // transfer speeda z plaszcza do skrytyki
    if(Request::post('stash_speed') && Request::post('stash_speed') > 0 && is_numeric(Request::post('stash_speed'))) {
      // sprawdzenie czy speed jest
      if(Request::post('stash_speed') > Session::get('coat_speed')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH SPEED ON YOU !');
        return false;
      }
      // dodanie speeda do skrytki
      Session::set('stash_speed', Session::get('stash_speed') + Request::post('stash_speed'));
      // odjecie speeda z plaszcza
      Session::set('coat_speed', Session::get('coat_speed') - Request::post('stash_speed'));
      // dodanie miejsca do plaszcza
      Session::set('hold', Session::get('hold') + Request::post('stash_speed'));
    }

    // transfer speeda ze skrytki do plaszcza
    if(Request::post('trench_speed') && Request::post('trench_speed') > 0 && is_numeric(Request::post('trench_speed'))) {
      // sprawdzenie czy kokaina jest
      if(Request::post('trench_speed') > Session::get('stash_speed')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH SPEED IN YOUR STASH !');
        return false;
      }
      // dodanie speeda do plaszcza
      Session::set('coat_speed', Session::get('coat_speed') + Request::post('trench_speed'));
      // odjecie miejsca z plaszcza
      Session::set('hold', Session::get('hold') - Request::post('trench_speed'));
      // odjecie speeda ze skrytki
      Session::set('stash_speed', Session::get('stash_speed') - Request::post('trench_speed'));
    }


    // transfer ludes z plaszcza do skrytyki
    if(Request::post('stash_ludes') && Request::post('stash_ludes') > 0 && is_numeric(Request::post('stash_ludes'))) {
      // sprawdzenie czy ludes jest
      if(Request::post('stash_ludes') > Session::get('coat_ludes')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH LUDES ON YOU !');
        return false;
      }
      // dodanie ludes do skrytki
      Session::set('stash_ludes', Session::get('stash_ludes') + Request::post('stash_ludes'));
      // odjecie ludes z plaszcza
      Session::set('coat_ludes', Session::get('coat_ludes') - Request::post('stash_ludes'));
      // dodanie miejsca do plaszcza
      Session::set('hold', Session::get('hold') + Request::post('stash_ludes'));
    }

    // transfer ludes ze skrytki do plaszcza
    if(Request::post('trench_ludes') && Request::post('trench_ludes') > 0 && is_numeric(Request::post('trench_ludes'))) {
      // sprawdzenie czy kokaina jest
      if(Request::post('trench_ludes') > Session::get('stash_ludes')) {
        Session::add('feedback_negative', 'YOU DON\'T HAVE THAT MUCH LUDES IN YOUR STASH !');
        return false;
      }
      // dodanie ludes do plaszcza
      Session::set('coat_ludes', Session::get('coat_ludes') + Request::post('trench_ludes'));
      // odjecie miejsca z plaszcza
      Session::set('hold', Session::get('hold') - Request::post('trench_ludes'));
      // odjecie ludes ze skrytki
      Session::set('stash_ludes', Session::get('stash_ludes') - Request::post('trench_ludes'));
    }

    return true;
  }

  // depozyt w banku
  public static function deposit() {

    // walidacja
    if(!is_numeric(Request::post('how_much_deposit')) || Request::post('how_much_deposit') < 0) {
      return false;
    }

    // sprawdzenie czy go na to stac
    if(Request::post('how_much_deposit') > Session::get('cash')) {
      Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
      return false;
    }

    // odjecie kasy z plaszcza
    Session::set('cash', Session::get('cash') - Request::post('how_much_deposit'));
    // dodanie kasy na konto
    Session::set('bank', Session::get('bank') + Request::post('how_much_deposit'));

    return true;

  }

  // pobranie kasy z banku
  public static function withdraw() {

    // walidacja
    if(!is_numeric(Request::post('how_much_withdraw')) || Request::post('how_much_withdraw') < 0) {
      return false;
    }

    // sprawdzenie czy go na to stac
    if(Request::post('how_much_withdraw') > Session::get('bank')) {
      Session::add('feedback_negative', 'YOU CAN\'T AFFORD THIS DUDE !');
      return false;
    }

    // odjecie kasy z konta
    Session::set('bank', Session::get('bank') - Request::post('how_much_withdraw'));
    // dodanie kasy do plaszcza
    Session::set('cash', Session::get('cash') + Request::post('how_much_withdraw'));

    return true;

  }

  // zapisanie wyniku w rankingu
  public static function update_ranking() {

    $database = DatabaseFactory::getFactory()->getConnection();

    $points = Session::get('cash') + Session::get('bank') - Session::get('debt');

    $name = Request::post('player_name', true);

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

    // zapisz wynik w bazie danych
		$sql = "INSERT INTO ranking (id, name, points, date)
                    VALUES (:id, :name, :points, :date)";
		$query = $database->prepare($sql);
		$query->execute(array(':id' => null,
		                      ':name' => $name,
		                      ':points' => $points,
		                      ':date' => time()));

		$count =  $query->rowCount();

    // jesli wszystko poszlo ok
		if ($count == 1) {
      // zmien tryb gry
      Session::set('game','end_screen');
      Session::set('user_name',$name);
			return true;
		}

		return false;

  }

  // pobierz ranking
  public static function get_ranking() {

    $database = DatabaseFactory::getFactory()->getConnection();

    $sql = "SELECT *
            FROM ranking
            ORDER BY points DESC;";

    $query = $database->prepare($sql);
    $query->execute();

    return $query->fetchAll();

  }

}
