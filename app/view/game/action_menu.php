<div id="actionMenu">

<div id="drugsPrices">
  <p><?php echo Options::get('TXT_WELCOME'); ?></p>
  
  <ul>
    <li><?php echo Options::get('PRODUCT_1'); ?> &nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_1"><?php echo Session::get('price_product_1'); ?></span></li>
    <li><?php echo Options::get('PRODUCT_2'); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_2"><?php echo Session::get('price_product_2'); ?></span></li>
    <li><?php echo Options::get('PRODUCT_3'); ?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_3"><?php echo Session::get('price_product_3'); ?></span></li>
  </ul>
  <ul>
    <li><?php echo Options::get('PRODUCT_4'); ?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_4"><?php echo Session::get('price_product_4'); ?></span></li>
    <li><?php echo Options::get('PRODUCT_5'); ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_5"><?php echo Session::get('price_product_5'); ?></span></li>
    <li><?php echo Options::get('PRODUCT_6'); ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_price_drug_6"><?php echo Session::get('price_product_6'); ?></span></li>
  </ul>
</div>

<?php $this->renderFeedbackMessages(); ?>

<?php

  // dodatkowe menu jesli pierwsza lokacja
  if(Session::get('user_location') == Options::get('LOCATION_1')) {

    echo '<p id="action_bronx_options">';
    echo '<a id="action_visit_loan_shark" href="#">'.Options::get('TXT_LOANSHARK').'</a>, <a id="action_transfer_drugs" href="#">'.Options::get('TXT_TRANSFER').'</a>, <a id="action_visit_bank" href="#">'.Options::get('TXT_BANK').'</a> ?';
    echo '</p>';

    // LOAN SHARK
    echo '<div id="loan_shark_form">
    <p>'.Options::get('TXT_LOANSHARK_WELCOME').'</p>
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
    <p>'.Options::get('TXT_TRANSFER_WELCOME').'</p>
    <form method="post" action="'.Config::get('URL').'game/transfer_drugs/">
      <table>
      <tr>
        <th>'.Options::get('TXT_TRANSFER_TABLE_A').'</th>
        <th>'.Options::get('TXT_TRANSFER_TABLE_B').'</th>
        <th>'.Options::get('TXT_TRANSFER_TABLE_C').'</th>
      </tr>
      <tr>
        <td>'.Options::get('PRODUCT_1').'</td>
        <td><input name="stash_product_1" type="text"></td>
        <td><input name="coat_product_1" type="text"></td>
      </tr>
      <tr>
        <td>'.Options::get('PRODUCT_2').'</td>
        <td><input name="stash_product_2" type="text"></td>
        <td><input name="coat_product_2" type="text"></td>
      </tr>
      <tr>
        <td>'.Options::get('PRODUCT_3').'</td>
        <td><input name="stash_product_3" type="text"></td>
        <td><input name="coat_product_3" type="text"></td>
      </tr>
      <tr>
        <td>'.Options::get('PRODUCT_4').'</td>
        <td><input name="stash_product_4" type="text"></td>
        <td><input name="coat_product_4" type="text"></td>
      </tr>
      <tr>
        <td>'.Options::get('PRODUCT_5').'</td>
        <td><input name="stash_product_5" type="text"></td>
        <td><input name="coat_product_5" type="text"></td>
      </tr>
      <tr>
        <td>'.Options::get('PRODUCT_6').'</td>
        <td><input name="stash_product_6" type="text"></td>
        <td><input name="coat_product_6" type="text"></td>
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
    <p>'.Options::get('TXT_BANK_WELCOME').'</p>
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
  <?php echo Options::get('TXT_MAIN_OPTIONS_START'); ?> <a id="action_buy" href="#"><?php echo Options::get('TXT_MAIN_OPTIONS_BUY'); ?></a>, <a id="action_sell" href="#"><?php echo Options::get('TXT_MAIN_OPTIONS_SELL'); ?></a> <?php echo Options::get('TXT_MAIN_OPTIONS_OR'); ?> <a id="action_jet" href="#"><?php echo Options::get('TXT_MAIN_OPTIONS_JET'); ?></a> ?
</p>

<div id="action_jet_where">
<p><?php echo Options::get('TXT_OPTIONS_JET_WHERE'); ?>    <a href="<?php echo Config::get('URL'); ?>game/jet_to/1/">1)  <?php echo Options::get('LOCATION_1'); ?></a>        <a href="<?php echo Config::get('URL'); ?>game/jet_to/2/">2)  <?php echo Options::get('LOCATION_2'); ?></a>          <a href="<?php echo Config::get('URL'); ?>game/jet_to/3/">3)  <?php echo Options::get('LOCATION_3'); ?></a>
                  <a href="<?php echo Config::get('URL'); ?>game/jet_to/4/">4)  <?php echo Options::get('LOCATION_4'); ?></a>    <a href="<?php echo Config::get('URL'); ?>game/jet_to/5/">5)  <?php echo Options::get('LOCATION_5'); ?></a>    <a href="<?php echo Config::get('URL'); ?>game/jet_to/6/">6)  <?php echo Options::get('LOCATION_6'); ?></a>

<a class="back_to_menu" href="#">Back to main menu</a></p>
</div>

<div id="action_buy_box">
<p id="action_buy_what">WHAT WILL YOU BUY ?    <a href="#" id="action_buy_1">1)  <?php echo Options::get('PRODUCT_1'); ?></a>        <a href="#" id="action_buy_2">2)  <?php echo Options::get('PRODUCT_2'); ?></a>          <a href="#" id="action_buy_3">3)  <?php echo Options::get('PRODUCT_3'); ?></a>
                       <a href="#" id="action_buy_4">4)  <?php echo Options::get('PRODUCT_4'); ?></a>           <a href="#" id="action_buy_5">5)  <?php echo Options::get('PRODUCT_5'); ?></a>           <a href="#" id="action_buy_6">6)  <?php echo Options::get('PRODUCT_6'); ?></a></p>

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
<p id="action_sell_what">WHAT WILL YOU SELL ?   <a href="#" id="action_sell_1">1)  <?php echo Options::get('PRODUCT_1'); ?></a>        <a href="#" id="action_sell_2">2)  <?php echo Options::get('PRODUCT_2'); ?></a>          <a href="#" id="action_sell_3">3)  <?php echo Options::get('PRODUCT_3'); ?></a>
                       <a href="#" id="action_sell_4">4)  <?php echo Options::get('PRODUCT_4'); ?></a>           <a href="#" id="action_sell_5">5)  <?php echo Options::get('PRODUCT_5'); ?></a>           <a href="#" id="action_sell_6">6)  <?php echo Options::get('PRODUCT_6'); ?></a></p>

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
