<?php
// Make an output card.
function card($head, $subhead, $bg_color, $txt_color, $output)
{
    $card = "
  <div class='card $txt_color $bg_color mb-3' style='max-width: 18rem;'>
    <div class='card-header'>$head</div>
    <div class='card-body'>
      <h5 class='card-title'>$subhead</h5>
      <p class='card-text' id='result'>$output</p>
    </div>
  </div>
  ";
    return $card;
}
