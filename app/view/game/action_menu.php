<div id="actionMenu">

<div id="drugsPrices">
  <p>HEY DUDE, THE PRICES OF DRUGS HERE ARE:</p>
  
  <ul>
    <li>COCAINE &nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_1"><?php echo Session::get('price_cocaine'); ?></span></li>
    <li>HEROIN  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_2"><?php echo Session::get('price_heroin'); ?></span></li>
    <li>ACID    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_3"><?php echo Session::get('price_acid'); ?></span></li>
  </ul>
  <ul>
    <li>WEED    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_4"><?php echo Session::get('price_weed'); ?></span></li>
    <li>SPEED   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_5"><?php echo Session::get('price_speed'); ?></span></li>
    <li>LUDES   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_6"><?php echo Session::get('price_ludes'); ?></span></li>
  </ul>
</div>

<?php $this->renderFeedbackMessages(); ?>

<?php

  // dodatkowe menu jesli pierwsza lokacja
  if(Session::get('user_location') == 'BRONX') {

    echo '<p id="action_bronx_options">';
    echo '<a id="action_visit_loan_shark" href="#">VISIT THE LOAN SHARK</a>, <a id="action_transfer_drugs" href="#">TRANSFER DRUGS TO YOUR STASH</a>, <a id="action_visit_bank" href="#">VISIT THE BANK</a> ?';
    echo '</p>';

    // LOAN SHARK
    echo '<div id="loan_shark_form">
    <p>HOW MUCH TO REPAY ? / HOW MUCH TO BORROW ?</p>
    <form method="post" action="'.Config::get('URL').'game/repay/">
      <input name="how_much_repay" type="text">
      <input type="submit" value="REPAY">
    </form>';

    echo '<form id="loan_shark_borrow_form" method="post" action="'.Config::get('URL').'game/borrow/">
      <input name="how_much_borrow" type="text">
      <input type="submit" value="BORROW">
    </form>
    <a class="back_to_menu" href="#">Back to main menu</a>
    </div>'; // #loan_shark_form

    // TRANSFER DRUGS TO / FROM STASH
    echo '

    <div id="transfer_drugs_form">
    <p>HOW MUCH TO TRANSFER ?</p>
    <form method="post" action="'.Config::get('URL').'game/transfer_drugs/">
      <table>
      <tr>
        <th>DRUG</th>
        <th>TO STASH</th>
        <th>TO TRENCH COAT</th>
      </tr>
      <tr>
        <td>COCAINE</td>
        <td><input name="stash_cocaine" type="text"></td>
        <td><input name="trench_cocaine" type="text"></td>
      </tr>
      <tr>
        <td>HEROIN</td>
        <td><input name="stash_heroin" type="text"></td>
        <td><input name="trench_heroin" type="text"></td>
      </tr>
      <tr>
        <td>ACID</td>
        <td><input name="stash_acid" type="text"></td>
        <td><input name="trench_acid" type="text"></td>
      </tr>
      <tr>
        <td>WEED</td>
        <td><input name="stash_weed" type="text"></td>
        <td><input name="trench_weed" type="text"></td>
      </tr>
      <tr>
        <td>SPEED</td>
        <td><input name="stash_speed" type="text"></td>
        <td><input name="trench_speed" type="text"></td>
      </tr>
      <tr>
        <td>LUDES</td>
        <td><input name="stash_ludes" type="text"></td>
        <td><input name="trench_ludes" type="text"></td>
      </tr>
      <tr>
        <td colspan="3"><input class="submit" type="submit" value="TRANSFER"></td>
      </tr>
      </table>
    </form>
    <a class="back_to_menu" href="#">Back to main menu</a>
    </div>';

    // VISIT THE BANK
    echo '<div id="visit_bank_form">
    <p>HOW MUCH TO DEPOSIT ? / HOW MUCH TO WITHDRAW ?</p>
    <form id="visit_bank_deposit_form" method="post" action="'.Config::get('URL').'game/deposit/">
      <input name="how_much_deposit" type="text">
      <input type="submit" value="DEPOSIT">
    </form>';

    echo '<form id="visit_bank_withdraw_form" method="post" action="'.Config::get('URL').'game/withdraw/">
      <input name="how_much_withdraw" type="text">
      <input type="submit" value="WITHDRAW">
    </form>
    <a class="back_to_menu" href="#">Back to main menu</a>
    </div>';

  }

?>

<p id="action_main_options">
  WILL YOU <a id="action_buy" href="#">BUY</a>, <a id="action_sell" href="#">SELL</a> OR <a id="action_jet" href="#">JET</a> ?
</p>

<div id="action_jet_where">
<p>WHERE TO DUDE:    <a href="<?php echo Config::get('URL'); ?>game/jet_to/1/">1)  BRONX</a>        <a href="<?php echo Config::get('URL'); ?>game/jet_to/2/">2)  GHETTO</a>          <a href="<?php echo Config::get('URL'); ?>game/jet_to/3/">3)  CENTRAL PARK</a>
                  <a href="<?php echo Config::get('URL'); ?>game/jet_to/4/">4)  MANHATTAN</a>    <a href="<?php echo Config::get('URL'); ?>game/jet_to/5/">5)  CONEY ISLAND</a>    <a href="<?php echo Config::get('URL'); ?>game/jet_to/6/">6)  BROOKLYN</a>

<a class="back_to_menu" href="#">Back to main menu</a></p>
</div>

<div id="action_buy_box">
<p id="action_buy_what">WHAT WILL YOU BUY ?    <a href="#" id="action_buy_1">1)  COCAINE</a>        <a href="#" id="action_buy_2">2)  HEROIN</a>          <a href="#" id="action_buy_3">3)  ACID</a>
                       <a href="#" id="action_buy_4">4)  WEED</a>           <a href="#" id="action_buy_5">5)  SPEED</a>           <a href="#" id="action_buy_6">6)  LUDES</a></p>

<div id="action_buy_how_much">
  HOW MUCH <span class="drug"></span> WILL YOU BUY? YOU CAN AFFORD ( <span class="afford"></span> )
  <form id="buy_drugs_form" method="post" action="#">
    <input name="quantity" type="text">
    <input type="submit" value="BUY">
  </form>
</div>
<a class="back_to_menu" href="#">Back to main menu</a>
</div>

<div id="action_sell_box">
<p id="action_sell_what">WHAT WILL YOU SELL ?   <a href="#" id="action_sell_1">1)  COCAINE</a>        <a href="#" id="action_sell_2">2)  HEROIN</a>          <a href="#" id="action_sell_3">3)  ACID</a>
                       <a href="#" id="action_sell_4">4)  WEED</a>           <a href="#" id="action_sell_5">5)  SPEED</a>           <a href="#" id="action_sell_6">6)  LUDES</a></p>

<div id="action_sell_how_much">
  HOW MUCH <span class="drug"></span> WILL YOU SELL?
  <form id="sell_drugs_form" method="post" action="#">
    <input name="quantity" type="text">
    <input type="submit" value="SELL">
  </form>
</div>
<a class="back_to_menu" href="#">Back to main menu</a>
</div>

</div>
