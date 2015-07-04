<div id="container">
<div id="mainMenu">
  <ul>
    <li><a href="<?php echo Config::get('URL'); ?>">Home</a></li>
    <li>-</li>
    <li><a href="<?php echo Config::get('URL').'skeletor/'; ?>">What is Skeletor?</a></li>
  </ul>
</div>

<?php $this->renderFeedbackMessages(); ?>

<img src="<?php echo Config::get('URL'); ?>pub/img/logo.png" alt="">

<h1 style="color: red;">Sorry, this page does not exist :(</h1>

</div>

<?php

  // var_dump($this);

?>
