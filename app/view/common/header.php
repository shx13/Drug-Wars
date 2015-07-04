<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8" />
<title>Drug Wars</title>

<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>pub/css/reset.css">
<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>pub/css/style.css">

<?php
  // add extra CSS (declared in the controller file)
  if(isset($this->extraCSS)) {
    foreach ($this->extraCSS as $xcss) {
      echo '<link rel="stylesheet" href="'.Config::get('URL').'pub/css/'.$xcss.'">'."\r\n";
    }
  }

  // add extra javascript (declared in the controller file)
  if(isset($this->extraJS)) {
    foreach ($this->extraJS as $xjs) {
      echo '<script src="'.Config::get('URL').'pub/js/'.$xjs.'"></script>'."\r\n";
    }
  }

?>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

</head>
<body>
