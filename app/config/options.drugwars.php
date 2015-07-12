<?php

/*
* Game Options
*
* You can basically set up everything in here, which can give you a completely new game.
* It can also be used to translate it into different language.
*/

return array(
  // MAIN OPTIONS
  'GAME_NAME'       => 'PHP WARS',
  'START_GAME_DATE' => strtotime('4-12-1983'), // original start date: 4-12-1983
	'END_GAME_DATE'   => strtotime('4-1-1984'),  // original end date: 4-1-1984

  // GAME LOCATIONS
  'LOCATION_1' => 'BRONX',
  'LOCATION_2' => 'GHETTO',
  'LOCATION_3' => 'CENTRAL PARK',
  'LOCATION_4' => 'MANHATTAN',
  'LOCATION_5' => 'CONEY ISLAND',
  'LOCATION_6' => 'BROOKLYN',

  // PLAYERS MERCHANDISE
  'PRODUCT_1' => 'COCAINE',
  'PRODUCT_2' => 'HEROIN',
  'PRODUCT_3' => 'ACID',
  'PRODUCT_4' => 'WEED',
  'PRODUCT_5' => 'SPEED',
  'PRODUCT_6' => 'LUDES',

  // MERCHANDISE PRICES
  'PRODUCT_1_MIN_PRICE' => 15000,
  'PRODUCT_1_MAX_PRICE' => 30000,

  'PRODUCT_2_MIN_PRICE' => 5000,
  'PRODUCT_2_MAX_PRICE' => 14000,

  'PRODUCT_3_MIN_PRICE' => 1000,
  'PRODUCT_3_MAX_PRICE' => 4500,

  'PRODUCT_4_MIN_PRICE' => 300,
  'PRODUCT_4_MAX_PRICE' => 900,

  'PRODUCT_5_MIN_PRICE' => 70,
  'PRODUCT_5_MAX_PRICE' => 250,

  'PRODUCT_6_MIN_PRICE' => 10,
  'PRODUCT_6_MAX_PRICE' => 60,

  // MAIN TABLE
  'TXT_MAIN_TABLE_DATE' => 'DATE',
  'TXT_MAIN_TABLE_HOLD' => 'HOLD',
  'TXT_MAIN_TABLE_STASH' => 'STASH',
  'TXT_MAIN_TABLE_TRENCH' => 'TRENCH COAT',

  // GAME MENU
  'TXT_WELCOME' => 'HEY DUDE, THE PRICES OF DRUGS HERE ARE:',

  'TXT_LOANSHARK' => 'VISIT THE LOAN SHARK',
  'TXT_TRANSFER' => 'TRANSFER DRUGS TO YOUR STASH',
  'TXT_BANK' => 'VISIT THE BANK',

  'TXT_MAIN_OPTIONS_START' => 'WILL YOU',
  'TXT_MAIN_OPTIONS_BUY' => 'BUY',
  'TXT_MAIN_OPTIONS_SELL' => 'SELL',
  'TXT_MAIN_OPTIONS_OR' => 'OR',
  'TXT_MAIN_OPTIONS_JET' => 'JET',

  'TXT_OPTIONS_JET_WHERE' => 'WHERE TO DUDE:',

  'TXT_LOANSHARK_WELCOME' => 'HOW MUCH TO REPAY ? / HOW MUCH TO BORROW ?',

  'TXT_TRANSFER_WELCOME' => 'HOW MUCH TO TRANSFER ?',
  'TXT_TRANSFER_TABLE_A' => 'DRUG',
  'TXT_TRANSFER_TABLE_B' => 'TO STASH',
  'TXT_TRANSFER_TABLE_C' => 'TO TRENCH COAT',

  'TXT_BANK_WELCOME' => 'HOW MUCH TO DEPOSIT ? / HOW MUCH TO WITHDRAW ?',

  /* RANDOM ENCOUNTERS
  
  * 01. Cocaine price * $multiplier
  * 02. Weed price / $multiplier
  * 03. Game date + X days
  * 04. -1 to -10 units of drugs from every category
  * 05. -1 to -20 units of weed
  * 06. Heroin price / $multiplier
  * 07. Adds 1 to 10 units of a single drug
  * 08. Ludes price / $multiplier
  * 09. Heroin price * $multiplier
  * 10. Acid price / $multiplier
  * 11. User cash / $multiplier
  *
  * Special encounters (requiring extra action)
  *
  * 12. Adds 10 to 25 units of coat space
  * 13. 50% for death, 50% for +1 points multiplier
  * 14. Buy a weapon for 300-500 to fight the cops
  * 30. Fight 1 to 6 cops
  */

  'TXT_RAND_ENCOUNTER_01' => 'COPS MADE A BIG COKE BUST !!  PRICES ARE OUTRAGEOUS !!',
  'TXT_RAND_ENCOUNTER_02' => 'COLOMBIAN FREIGHTER DUSTED THE COAST GUARD !!  WEED PRICES HAVE BOTTOMED OUT !!',
  'TXT_RAND_ENCOUNTER_03' => 'POLICE DOGS CHASE YOU FOR [daysLost] BLOCKS',
  'TXT_RAND_ENCOUNTER_04' => 'YOU DROPPED SOME DRUGS !!  THAT\'S A DRAG MAN !!',
  'TXT_RAND_ENCOUNTER_05' => 'YOUR MAMA MADE SOME BROWNIES AND USED YOUR WEED !! THEY WERE GREAT !!',
  'TXT_RAND_ENCOUNTER_06' => 'PIGS ARE SELLING CHEAP HEROIN FROM LAST WEEKS RAID !!',
  'TXT_RAND_ENCOUNTER_07' => 'YOU FIND [findHowMany] UNITS OF [findWhat] ON A DEAD DUDE IN THE SUBWAY !!',
  'TXT_RAND_ENCOUNTER_08' => 'RIVAL DRUG DEALERS RADED A PHARMACY AND ARE SELLING  C H E A P   L U D E S !!!',
  'TXT_RAND_ENCOUNTER_09' => 'ADDICTS ARE BUYING HEROIN AT OURAGEOUS PRICES !!',
  'TXT_RAND_ENCOUNTER_10' => 'THE MARKET HAS BEEN FLOODED WITH CHEAP HOME MADE ACID !!!',
  'TXT_RAND_ENCOUNTER_11' => 'YOU WERE MUGGED IN THE SUBWAY !!',
  'TXT_RAND_ENCOUNTER_12' => 'DO YOU WANT TO BUY A NEW COAT FOR [coatPrice] ?',
  'TXT_RAND_ENCOUNTER_13' => 'THERE IS SOME WEED THAT SMELLS LIKE PARAQUAT HERE !! IT LOOKS GOOD !! WILL YOU SMOKE IT ?',
  'TXT_RAND_ENCOUNTER_14' => 'WILL YOU BUY A .38 SPECIAL FOR [gunPrice] ?',
  'TXT_RAND_ENCOUNTER_30' => 'OFFICER HARDASS AND [enemyNo] OF HIS DEPUTIES ARE CHASING YOU !!!!!',

  'TXT_HARDASS_DAMAGE' => 'DAMAGE',
  'TXT_HARDASS_ENEMY' => 'COPS',
  'TXT_HARDASS_GUNS' => 'GUNS'

    'TXT_INSTRUCTIONS' => "This is a game of buying, selling, and fighting. The object of the game is to
pay off your debt to the loan shark. Then, make as much money as you can in
a 1 month period. If you deal too heavily in  drugs,  you  might  run  into
the police !!  Your main drug stash will be in the Bronx. (It's a nice
neighborhood)!

The prices of drugs per unit are:\r\n"

);
