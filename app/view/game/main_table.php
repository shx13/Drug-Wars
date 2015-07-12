<div id="gameBox">

<h1><?php echo Options::get('GAME_NAME'); ?></h1>

<h6 class="date"><?php echo Options::get('TXT_MAIN_TABLE_DATE'); ?> <?php echo date('m/d/Y', Session::get('game_date')); ?></h6>
<h6 class="hold"><?php echo Options::get('TXT_MAIN_TABLE_HOLD'); ?> <?php echo Session::get('hold'); ?></h6>
<table class="top">
  <tr>
    <td class="stash"><?php echo Options::get('TXT_MAIN_TABLE_STASH'); ?></td>
    <td class="loc"><?php echo Session::get('user_location'); ?></td>
    <td class="trench"><?php echo Options::get('TXT_MAIN_TABLE_TRENCH'); ?></td>
  </tr>
</table>
<table class="bottom">
  <tr>
    <td>
      <ul>
        <li><?php echo Options::get('PRODUCT_1'); ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('stash_product_1'); ?></li>
        <li><?php echo Options::get('PRODUCT_2'); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('stash_product_2'); ?></li>
        <li><?php echo Options::get('PRODUCT_3'); ?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('stash_product_3'); ?></li>
        <li><?php echo Options::get('PRODUCT_4'); ?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('stash_product_4'); ?></li>
        <li><?php echo Options::get('PRODUCT_5'); ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('stash_product_5'); ?></li>
        <li><?php echo Options::get('PRODUCT_6'); ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('stash_product_6'); ?></li>
        <br>
        <li>BANK    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('bank'); ?></li>
        <li>DEBT    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('debt'); ?></li>
      </ul>
    </td>
    <td>
      <ul>
        <li><?php echo Options::get('PRODUCT_1'); ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('coat_product_1'); ?></li>
        <li><?php echo Options::get('PRODUCT_2'); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('coat_product_2'); ?></li>
        <li><?php echo Options::get('PRODUCT_3'); ?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('coat_product_3'); ?></li>
        <li><?php echo Options::get('PRODUCT_4'); ?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('coat_product_4'); ?></li>
        <li><?php echo Options::get('PRODUCT_5'); ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('coat_product_5'); ?></li>
        <li><?php echo Options::get('PRODUCT_6'); ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('coat_product_6'); ?></li>
        <br>
        <li>GUNS    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Session::get('guns'); ?></li>
        <li>CASH    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="js_coat_cash"><?php echo Session::get('cash'); ?></span></li>
      </ul>
    </td>
  </tr>
</table>

</div>
