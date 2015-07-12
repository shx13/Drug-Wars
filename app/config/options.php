<?php

/*
* Game Options
*
* You can basically set up everything in here, which can give you a completely new game.
* It can also be used to translate it into different language.
*/

return array(
  // MAIN OPTIONS
  'GAME_NAME'       => 'SAILOR WARS',
  'START_GAME_DATE' => strtotime('23-8-1869'),
	'END_GAME_DATE'   => strtotime('23-9-1869'),

  // GAME LOCATIONS
  'LOCATION_1' => 'DUBLIN',
  'LOCATION_2' => 'LONDON',
  'LOCATION_3' => 'CASABLANCA',
  'LOCATION_4' => 'LE HAVRE',
  'LOCATION_5' => 'NEW YORK',
  'LOCATION_6' => 'SAVANNAH',

  // PLAYERS MERCHANDISE
  'PRODUCT_1' => 'IVORY',
  'PRODUCT_2' => 'WINE',
  'PRODUCT_3' => 'TEA',
  'PRODUCT_4' => 'COAL',
  'PRODUCT_5' => 'WOOL',
  'PRODUCT_6' => 'COTTON',

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
  'TXT_MAIN_TABLE_STASH' => 'WAREHOUSE',
  'TXT_MAIN_TABLE_TRENCH' => 'SHIP',

  // GAME MENU
  'TXT_WELCOME' => 'AHOY CAPTAIN, THE PRICES OF THE MERCHANDISE AT THIS PORT ARE:',

  'TXT_LOANSHARK' => 'VISIT THE LOAN SHARK',
  'TXT_TRANSFER' => 'TRANSFER MERCHANDISE TO YOUR WAREHOUSE',
  'TXT_BANK' => 'VISIT THE BANK',

  'TXT_MAIN_OPTIONS_START' => 'WILL YOU',
  'TXT_MAIN_OPTIONS_BUY' => 'BUY',
  'TXT_MAIN_OPTIONS_SELL' => 'SELL',
  'TXT_MAIN_OPTIONS_OR' => 'OR',
  'TXT_MAIN_OPTIONS_JET' => 'SAIL AWAY',

  'TXT_OPTIONS_JET_WHERE' => 'WHERE TO CAPTAIN:',

  'TXT_LOANSHARK_WELCOME' => 'HOW MUCH TO REPAY ? / HOW MUCH TO BORROW ?',

  'TXT_TRANSFER_WELCOME' => 'HOW MUCH TO TRANSFER ?',
  'TXT_TRANSFER_TABLE_A' => 'PRODUCT',
  'TXT_TRANSFER_TABLE_B' => 'TO WAREHOUSE',
  'TXT_TRANSFER_TABLE_C' => 'ONTO SHIP',

  'TXT_BANK_WELCOME' => 'HOW MUCH TO DEPOSIT ? / HOW MUCH TO WITHDRAW ?',

  /* RANDOM ENCOUNTERS
  
  * 01. Product 1 price * $multiplier
  * 02. Product 4 price / $multiplier
  * 03. Game date + X days - !important [daysLost] is being replaced with the number of actual days
  * 04. -1 to -10 units of products from every category
  * 05. -1 to -20 units of Product 4
  * 06. Product 2 price / $multiplier
  * 07. Adds 1 to 10 units of a single product
  * 08. Product 6 price / $multiplier
  * 09. Product 2 price * $multiplier
  * 10. Product 3 price / $multiplier
  * 11. User cash / $multiplier
  *
  * Special encounters (requiring extra action)
  *
  * 12. Adds 10 to 25 units of coat space
  * 13. 50% for death, 50% for +1 points multiplier
  * 14. Buy a weapon for 300-500 to fight the enemies
  * 15. Fight 1 to 6 enemies
  */

  'TXT_RAND_ENCOUNTER_01' => 'PIRATES MADE A BIG IVORY BUST !!  PRICES ARE OUTRAGEOUS !!',
  'TXT_RAND_ENCOUNTER_02' => 'PIRATES ARE SELLING STOLEN COAL !!  COAL PRICES HAVE BOTTOMED OUT !!',
  'TXT_RAND_ENCOUNTER_03' => 'PIRATES CHASE YOU FOR [daysLost] DAYS',
  'TXT_RAND_ENCOUNTER_04' => 'SOME OF YOUR MERCHANDISE HAS ROT !!',
  'TXT_RAND_ENCOUNTER_05' => 'YOUR COOK HAS USED SOME OF THE COAL TO MAKE FIRE UNDER THE POTS !!',
  'TXT_RAND_ENCOUNTER_06' => 'PIRATES ARE SELLING CHEAP WINE FROM LAST WEEKS RAID !!',
  'TXT_RAND_ENCOUNTER_07' => 'YOUR CREW FINDS [findHowMany] UNITS OF [findWhat] ON THE BEACH !!',
  'TXT_RAND_ENCOUNTER_08' => 'PIRATES ARE SELLING CHEAP COTTON FROM LAST WEEKS RAID !!',
  'TXT_RAND_ENCOUNTER_09' => 'PORTS ARE BUYING WINE AT OURAGEOUS PRICES !!',
  'TXT_RAND_ENCOUNTER_10' => 'THE MARKET HAS BEEN FLOODED WITH CHEAP TEA !!!',
  'TXT_RAND_ENCOUNTER_11' => 'YOU WERE MUGGED AT THE INN !!',
  'TXT_RAND_ENCOUNTER_12' => 'DO YOU WANT TO BUY A NEW, BIGGER CRATES FOR YOUR MERCHANDISE FOR [coatPrice] ?',
  'TXT_RAND_ENCOUNTER_13' => 'THERE IS SOME TOBACCO THAT SMELLS LIKE PARAQUAT HERE !! IT LOOKS GOOD !! WILL YOU SMOKE IT ?',
  'TXT_RAND_ENCOUNTER_14' => 'WILL YOU BUY A NEW CANNON FOR [gunPrice] ?',
  'TXT_RAND_ENCOUNTER_30' => 'CAPTAIN BLACKBEARD AND [enemyNo] OF HIS PIRATE SHIPS ARE CHASING YOU !!!!!',

  'TXT_HARDASS_DAMAGE' => 'DAMAGE',
  'TXT_HARDASS_ENEMY' => 'PIRATES',
  'TXT_HARDASS_GUNS' => 'CANNONS',

  'TXT_INSTRUCTIONS' => "This is a game of buying, selling, and fighting. The object of the game is to
pay off your debt to the loan shark. Then, make as much money as you can
in a 1 month period. Watch the sea,  as  you  might  run  into  the pirates !!
Your main warehouse will be in Dublin.

The prices of merchandise per unit are:\r\n"

);
