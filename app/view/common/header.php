<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8" />
<title><?php echo Options::get('GAME_NAME'); ?></title>

<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>pub/css/reset.css">
<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>pub/css/style.css">

<?php
  // add extra CSS (declared in the controller file)
  if(isset($this->extraCSS)) {
    foreach ($this->extraCSS as $xcss) {
      echo '<link rel="stylesheet" href="'.Config::get('URL').'pub/css/'.$xcss.'">'."\r\n";
    }
  }

  // add jQuery
  echo "\r\n".'<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>'."\r\n";

  // add extra javascript (declared in the controller file)
  if(isset($this->extraJS)) {
    foreach ($this->extraJS as $xjs) {
      echo '<script type="text/javascript" src="'.Config::get('URL').'pub/js/'.$xjs.'"></script>'."\r\n";
    }
  }
?>

</head>
<body>

<div id="topMenu">

  <?php
    // if the game is not off, show the link that allows to go back to it
    if(Session::get('game') != null) echo '<a href="'.Config::get('URL').'game/">Game</a> - ';
  ?>

  <a href="<?php echo Config::get('URL'); ?>info/instructions/">Instructions</a> -
  <a href="<?php echo Config::get('URL'); ?>info/top_scores/">Top Scores</a>
  <a class="right" href="<?php echo Config::get('URL'); ?>">Back to Main Menu</a>

  <?php
    // if the game is on, show the option to end it
    if(Session::get('game') == 'on') echo ' - <a href="'.Config::get('URL').'game/end_game/">End Game</a>';
  ?>

</div>
