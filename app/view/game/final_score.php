<div id="gameBox">

<h1>THE END</h1>

<?php

$this->renderFeedbackMessages();

echo '<p>Your score: '.(Session::get('cash') - Session::get('debt')).'</p>';

?>

<p>Enter your name:</p>
<form method="POST" action="<?php echo Config::get('URL'); ?>game/update_ranking_action/">
<input type="text" name="player_name">
<input type="submit">
</form>

</div>