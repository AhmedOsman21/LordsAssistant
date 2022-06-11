<?php
// Stylesheet Name
$style = 'forms';

// Import Autoloader
require_once "../autoloader.php";

// Import Output Card Creator.
require_once "output_card.php";

// Check whether occur
// $error_occur = false;

// // Error Handling
// function err($err_type) {
//   global $error_occur;
//   global $err_msg;
//   $error_occur = true;
//   $empty_field = "Please, make sure fields are not empty before submitting!";
//   $completed = "Congratulations, You've completed the event";
//   $input_zero = "Points can't be zero or less!";
//   $invalid_input = "Please, type valid numbers in the points field!";
//   $no_quests = "Sorry, you've ran out of quests!";

//   // Empty Field
//   if ($err_type === "empty_field") {
//     $err_msg = $empty_field;
//   }

//   // When required points are less than current points.
//   if ($err_type === "completed") {
//     $err_msg = $completed;
//   }

//   // When zero or less is typed in the points field.
//   if ($err_type === "input_zero") {
//     $err_msg = $input_zero;
//   }

//   // Wrong datatype inside points fields.
//   if ($err_type === "invalid_input") {
//     $err_msg = $invalid_input;
//   }


//   // When user run out of tasks
//   if ($err_type == "zero_division") {
//     $err_msg = "$no_quests";
//   }

//   // No quests left.
//   if ($err_type == "no_quests") {
//     $err_msg = $no_quests;
//   }

//   return $err_msg;
// }

// Instanciate validator object
$validator = new Validator;

// Calculator Variables
$guild_level = $cur_pts = $req_pts = $complete_quests = $include_bonus = "";

// Error Variables
$logic_err = $cur_pts_err = $req_pts_err = "";

// Card Variables.
$head = $subhead = $card_color = $text_color = "";


// Intiallize Form Variables
$cur_pts = "";
$req_pts = "";
$complete_quests = 0;
$include_bonus = false;
$total_quests = 10;

// Check Request Method
if ($_SERVER['REQUEST_METHOD'] === "POST") {

  // Current Points Validation.
  if (empty($_POST['cur_pts'])) {
    $cur_pts_err = "Current points' field is required!";
  } elseif (!$validator->validate($_POST['cur_pts'], "number")) {
    $cur_pts_err = "Please, type a valid number!";
  } else {
    $cur_pts = +$validator->clean_input($_POST['cur_pts']);
  }

  // Required Points Validation.
  if (empty($_POST['req_pts'])) {
    $req_pts_err = "Required points cannot be empty!";
  } elseif (!$validator->validate($_POST['req_pts'], "number")) {
    $req_pts_err = "Please, enter a valid number!";
  } else {
    $req_pts = +$validator->clean_input($_POST['req_pts']);
  }

  // Guild Tier.
  $guild_level = $_POST['guild_level'];

  // Completed Quests
  $complete_quests = +$_POST['complete_quests'];

  // [Checkbox] Including Bonus Validation.
  if (isset($_POST['include_bonus'])) {
    $include_bonus = true;
  }

  // // Form Variables & Sanitizing Form Inputs
  // if (isset($_POST['cur_pts']) && isset($_POST['req_pts']) && isset($_POST['guild_level'])) {
  //   $guild_level = $_POST['guild_level'];
  //   $cur_pts = $_POST['cur_pts'];
  //   $req_pts = $_POST['req_pts'];
  //   $complete_quests = (int) $_POST['complete_quests'];
  //   if (isset($_POST['include_bonus'])) {
  //     $include_bonus = (bool) $_POST['include_bonus'];
  //   }
  // }




  // Check Guild Level & Set total tasks according to it.
  switch ($guild_level):
    case "master":
      $total_quests = 10;
      break;
    case "expert":
      $total_quests = 9;
      break;
    case "advanced":
      $total_quests = 8;
      break;
    case "intermediate":
      $total_quests = 7;
      break;
    case "beginner":
      $total_quests = 6;
      break;
  endswitch;


  // Check if bonus quest is included.
  if ($include_bonus) {
    $total_quests++;
  }

  // Calculation
  $pts_left = $req_pts - $cur_pts;
  $quests_left = $total_quests - $complete_quests;

  
  // Required points achieved or less than the current points.
  if ($pts_left <= 0) {
    $logic_err = "Current points should be less than required points";
    $output_card = card("Oops!", "Error Occured", "bg-success", "text-white", $logic_err);

    // No tasks left BUT there are points left.
  } elseif ($quests_left === 0 && $pts_left > 0) {
    $logic_err = "Sorry, you've ran out of quests, and still didn't achieve the required points";
    $output_card = card("Oops!", "Bad news.", "bg-dark", "text-white", $logic_err);
    // No Errors
  }elseif ($pts_left !== 0) {
    $result = ceil($pts_left / $quests_left);
    // Output Code
    ob_start();
?>
    Quests that are above <strong style='color: var(--bs-success);'> <?= $result ?> </strong> points.
    <br>
    <br>

    <!-- Button trigger modal -->
    <button id="expand-output-details" class="btn btn-outline-success btn-sm">
      Details
    </button>


    <div id="output-details" style="display: none;">
      <strong>You have: </strong>
      <br>
      ➜ <span style='color: var(--bs-success);'> <?= $pts_left ?> </span> points left. 
      <br>
      ➜ <span style='color: var(--bs-success);'> <?= $quests_left ?> </span> quest left. </span>
    </div>


<?php
    $output = ob_get_clean();
    $output_card = card("Result", "Focus on:", "bg-dark", "text-white", $output);

  } 
}


?>

<!-- Header -->
<?php include "../include/header.php" ?>

<body>
  <!-- Navbar -->
  <?php include "../include/nav.php" ?>

  <!-- Form Container -->
  <div class="container main-container">

    <!-- Form Heading -->
    <div class="row mt-5 mb-3 heading">
      <h2><span><img src="../images/gf/g-lvl-master.png" alt="Guild Fest icon" class="head-icon"></span> Guild Fest Calculator</h2>
    </div>

    <!-- Calculator Info -->
    <div class="row">
      <div class="description alert alert-success alert-dismissible fade show" role="alert">
        Help you know what tasks you should focus on to get your GF done!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>

    <!-- Result -->
    <div class="container result">
      <div class="col-md-6 col-lg-6 col-10 result">
        <?php
        if (isset($output_card)) {
          echo $output_card;
        }
        ?>
      </div>
    </div>

    <!-- Calculator Form -->
    <div class="row form-container">
      <form class="row g-3 mb-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <!-- Current Points -->
        <div class="col-md-6">
          <label for="cur-pts" class="form-label">Current points</label>
          <input type="text" class="form-control" id="cur-pts" name="cur_pts" placeholder="Your current points">
        </div>

        <!-- Required Points -->
        <div class="col-md-6">
          <label for="req-pts" class="form-label">Required points</label>
          <input type="text" class="form-control" id="req-pts" name="req_pts" placeholder="Points to be achieved">
        </div>

        <!-- Guild Level -->
        <div class="col-md-6">
          <div class="gl row">
            <div class="form-label">Guild Tier</div>

            <!-- Master -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="master" value="master" checked>
              <label class="form-check-label" for="master">
                <span><img src="../images/gf/g-lvl-master.png" alt="Master Gauntlet" width='15' height='15'></span>
              </label>
            </div>

            <!-- Expert -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="expert" value="expert">
              <label class="form-check-label" for="expert">
                <span><img src="../images/gf/g-lvl-expert.png" alt="Expert Gauntlet" width='15' height='15'></span>
              </label>
            </div>

            <!-- Advanced -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="advanced" value="advanced">
              <label class="form-check-label" for="advanced">
                <span><img src="../images/gf/g-lvl-advanced.png" alt="Advanced Gauntlet" width='15' height='15'></span>
              </label>
            </div>

            <!-- Intermediate -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="intermediate" value="intermediate">
              <label class="form-check-label" for="intermediate">
                <span><img src="../images/gf/g-lvl-intermediate.png" alt="Intermediate Gauntlet" width='15' height='15'></span>
              </label>
            </div>

            <!-- Beginner -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="beginner" value="beginner">
              <label class="form-check-label" for="beginner">
                <span><img src="../images/gf/g-lvl-beginner.png" alt="Beginner Gauntlet" width='15' height='15'></span>
              </label>
            </div>
          </div>
        </div>

        <!-- Completed Quests -->
        <div class="col-md-6">
          <label for="comp-q" class="form-label">Completed Quests</label>
          <select id="comp-q" class="form-select" name="complete_quests">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        </div>

        <!-- Checkbox -->
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck" name="include_bonus" value="true">
            <label class="form-check-label" for="gridCheck" id="include_bonus">
              I'll make the bonus quest.
            </label>
          </div>
        </div>

        <!-- Calculate Button -->
        <div class="col-12 submit">
          <button type="submit" class="btn submit-btn btn-success">Calculate</button>
        </div>
      </form>
    </div>
  </div>

  <?php require "../include/footer.php" ?>
  <script src="../js/gf.js"></script>
</body>

</html>