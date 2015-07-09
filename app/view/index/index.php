<div id="startScreen">

  <?php $this->renderFeedbackMessages(); ?>

  <h6>GameGraveyard.net presents...<br>Remake of John E. Dell 1984 Cult Game</h6>
  <h1>DRUG WARS</h1>

  <ul>
    <?php echo (Session::get('game') == null ? '<li><a href="'.Config::get('URL').'game/start_game/">Start New Game</a></li>' : '<li><a href="'.Config::get('URL').'game/">Back to Game</a></li>'); ?>
    <li><a href="<?php echo Config::get('URL'); ?>info/top_scores/">Top Scores</a></li>
    <li><a href="<?php echo Config::get('URL'); ?>info/instructions/">Instructions</a></li>
  </ul>

</div>
