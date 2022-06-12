<?php
// Make an output card.
function card($head, $subhead, $bg_color, $txt_color, $output)
{
  // Card template
  ob_start()?>
  <div class='card <?= $txt_color ?> <?= $bg_color ?> mb-3' style='max-width: 18rem;'>
    <div class='card-header'> <?= $head ?> </div>
    <div class='card-body'>
      <h5 class='card-title'> <?=$subhead ?> </h5>
      <p class='card-text' id='result'> <?= $output ?> </p>
    </div>
  </div> 
  <?php 
  // Card Variable
  $card = ob_get_clean();


  return $card;
}
