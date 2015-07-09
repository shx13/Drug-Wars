<div id="topScores">

<h1>TOP SCORES</h1>

<table>

  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Date</th>
    <th>Points</th>
  </tr>

  <?php

    $position = 1;

    foreach($this->ranking as $score) {
      echo '<tr>';
      echo '<td>'.$position.'</td>';
      echo '<td>'.$score->name.'</td>';
      echo '<td>'.date('m/d/Y', $score->date).'</td>';      
      echo '<td>'.$score->points.'</td>';
      echo '</tr>';
      $position++;
    }

  ?>

</table>

</div>
