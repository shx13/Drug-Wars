<?php

echo '<div id="actionMenu">';

$this->renderFeedbackMessages();

// kupowanie nowego plaszcza
if(Session::get('user_action') == 12) {

  echo '<p>DO YOU WANT TO BUY A NEW COAT FOR '.(Session::get('user_coat_price')).' ?</p>';
  echo '<form method="post" action="'.Config::get('URL').'game/action/">
  <input name="action" type="submit" value="yes">
  <input name="action" type="submit" value="no">
  </form>';

}

// joint
elseif(Session::get('user_action') == 13) {

  echo '<p>THERE IS SOME WEED THAT SMELLS LIKE PARAQUAT HERE !! IT LOOKS GOOD !!<br>WILL YOU SMOKE IT ?</p>';
  echo '<form method="post" action="'.Config::get('URL').'game/action/">
  <input name="action" type="submit" value="yes">
  <input name="action" type="submit" value="no">
  </form>';

}

// bron
elseif(Session::get('user_action') == 14) {

  echo '<p>WILL YOU BUY A .38 SPECIAL FOR '.(Session::get('user_gun_price')).' ?</p>';
  echo '<form method="post" action="'.Config::get('URL').'game/action/">
  <input name="action" type="submit" value="yes">
  <input name="action" type="submit" value="no">
  </form>';

}

// officer hardass - info o walce
elseif(Session::get('user_action') == 30) {

  echo '<p>OFFICER HARDASS AND '.(Session::get('cops') - 1).' OF HIS DEPUTIES ARE CHASING YOU !!!!!</p>';
  echo '<form method="post" action="'.Config::get('URL').'game/action/">
  <input name="action" type="submit" value="ok">
  </form>';

}

// officer hardass - walka
elseif(Session::get('user_action') == 31) {

  // opcja fight dostepna tylko gdy mamy bron
  echo '<p>WILL YOU RUN '.(Session::get('guns') > 0 ? 'OR FIGHT ' : null).'?</p>';
  echo '<form method="post" action="'.Config::get('URL').'game/action/">';

  // opcja fight dostepna tylko gdy mamy bron
  if(Session::get('guns') > 0) echo '<input name="action" type="submit" value="fight">';

  echo '<input name="action" type="submit" value="run">
  </form>';

}

// officer hardass - podsumowanie wygranej walki
elseif(Session::get('user_action') == 32) {

  // echo '<p>YOU KILLED ALL OF THEM !!!!</p>';
  echo '<form method="post" action="'.Config::get('URL').'game/action/">
  <input name="action" type="submit" value="ok">
  </form>';

}

echo '</div>';
