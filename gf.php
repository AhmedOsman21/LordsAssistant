<!-- Page Stylesheet -->
<?php $style = 'forms' ?>


<!-- Calculator Logic -->
<?php

// Check if there are errors
$error_occur = false;





// Error Handling
function err($err_type)
{
  global $error_occur;
  global $err_msg;
  $error_occur = true;
  $empty_field = "Please, make sure fields are not empty before submitting!";
  $completed = "Congratulations, You've completed the event";
  $input_zero = "Points can't be zero or less!";
  $invalid_input = "Please, type valid numbers in the points field!";
  $no_quests = "Sorry, you've ran out of quests!";

  // Empty Field
  if ($err_type === "empty_field") {
    $err_msg = $empty_field;
  }

  // When required points are less than current points.
  if ($err_type === "completed") {
    $err_msg = $completed;
  }

  // When zero or less is typed in the points field.
  if ($err_type === "input_zero") {
    $err_msg = $input_zero;
  }

  // Wrong datatype inside points fields.
  if ($err_type === "invalid_input") {
    $err_msg = $invalid_input;
  }


  // When user run out of tasks
  if ($err_type == "zero_division") {
    $err_msg = "$no_quests";
  }

  // No quests left.
  if ($err_type == "no_quests") {
    $err_msg = $no_quests;
  }

  return $err_msg;
}


// Include output card file to import Card Function.
require_once "output_card.php";


// Card Variables.
$head = "";
$subhead = "";
$card_color = "";
$text_color = "";


// Intiallize Form Variables
$cur_pts = "";
$req_pts = "";
$guild_level = 'master';
$complete_quests = "";
$include_bonus = false;


// Check Request Method
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  // Form Variables & Sanitizing Form Inputs
  if (isset($_POST['cur_pts']) && isset($_POST['req_pts']) && isset($_POST['guild_level'])) {
    // $cur_pts = (int) filter_var($_POST['cur_pts'], FILTER_SANITIZE_NUMBER_INT);
    // $req_pts = (int) filter_var($_POST['req_pts'], FILTER_SANITIZE_NUMBER_INT);
    // $guild_level = $_POST['guild_level'];
    $cur_pts = $_POST['cur_pts'];
    $req_pts = $_POST['req_pts'];
    $complete_quests = (int) $_POST['complete_quests'];
    if (isset($_POST['include_bonus'])) {
      $include_bonus = (bool) $_POST['include_bonus'];
    }
  }


  // Validate Inputs
  if (!empty($cur_pts) && !empty($req_pts)) {
    // Inputs aren't valid
    if (!filter_var($cur_pts, FILTER_VALIDATE_INT) || !filter_var($req_pts, FILTER_VALIDATE_INT)) {
      $err = card("Error!", "Invalid input", "bg-danger", "text-white", err("invalid_input"));

      // Inputs are valid.
    } else {
      $cur_pts = (int) filter_var($cur_pts, FILTER_SANITIZE_NUMBER_INT);
      $req_pts = (int) filter_var($req_pts, FILTER_SANITIZE_NUMBER_INT);

      // Check negative values
      if ($cur_pts < 0 || $req_pts < 0) {
        $err = card("Error!", "Invalid input", "bg-danger", "text-white", err('input_zero'));

        //  Values are valid.
      } else {

        if ($cur_pts > $req_pts && !empty($req_pts)) {
          $err = card("Congratulations!", "Nothing to worry about.", "bg-dark", "text-white", err('completed'));
        }
      }

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

      // Make sure division is not by zero
      if ($pts_left !== 0 && $quests_left != 0) {
        $result = $pts_left / $quests_left;
        // Output
        $res_msg = "Quests above <strong style='color: var(--bs-success);'>" . ceil($result) . "</strong> points, to achieve the required points";
        $result = card("Result", "You should focus on", "bg-dark", "text-white", $res_msg);

        // No Points Left = Completed.
      } else if ($pts_left <= 0) {
        $err = card("Congratulations!", "Nothing to worry about", "bg-success", "text-white", err('completed'));

        // No tasks left BUT there are points left.
      } else if ($quests_left === 0 && $pts_left > 0) {
        $err = card("Oops!", "Bad news.", "bg-dark", "text-white", err('no_quests'));
      }
    }
    // Empty Inputs
  } else {
    $err = card("Error!", "Fields are empty.", "bg-danger", "text-white", err('empty_field'));
  }

  // Output
  $ouput = "";
  if ($error_occur) {
    $output = $err;
  } else {
    if (isset($result)) {
      $output = $result;
    }
  }
}











?>

<?php include "header.php" ?>

<body>
  <?php include "nav.php" ?>







  <div class="container main-container">
    <div class="row mt-5 mb-3 heading">
      <h2><span><img src="images/gf/g-lvl-master.png" alt="Guild Fest icon" class="head-icon"></span> Guild Fest Calculator</h2>
    </div>
    <div class="row">
      <div class="description alert alert-success alert-dismissible fade show" role="alert">
        Help you know what tasks you should focus on to get your GF done!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>

    <!-- Return The Result -->
    <div class="container result">
      <div class="col-md-6 col-lg-6 col-10 result">

        <?php if (isset($output)) {
          echo $output;
        } ?>
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
                <span><img src="images/gf/g-lvl-master.png" alt="Master Gauntlet" width='15' height='15'></span>
              </label>
            </div>
            <!-- Expert -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="expert" value="expert">
              <label class="form-check-label" for="expert">
                <span><img src="images/gf/g-lvl-expert.png" alt="Expert Gauntlet" width='15' height='15'></span>
              </label>
            </div>

            <!-- Advanced -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="advanced" value="advanced">
              <label class="form-check-label" for="advanced">
                <span><img src="images/gf/g-lvl-advanced.png" alt="Advanced Gauntlet" width='15' height='15'></span>
              </label>
            </div>

            <!-- Intermediate -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="intermediate" value="intermediate">
              <label class="form-check-label" for="intermediate">
                <span><img src="images/gf/g-lvl-intermediate.png" alt="Intermediate Gauntlet" width='15' height='15'></span>
              </label>
            </div>

            <!-- Beginner -->
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="guild_level" id="beginner" value="beginner">
              <label class="form-check-label" for="beginner">
                <span><img src="images/gf/g-lvl-beginner.png" alt="Beginner Gauntlet" width='15' height='15'></span>
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
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck" name="include_bonus" value="true">
            <label class="form-check-label" for="gridCheck">
              I'll make the bonus quest.
            </label>
          </div>
        </div>
        <div class="col-12 submit">
          <button type="submit" class="btn submit-btn btn-success">Calculate</button>
        </div>
      </form>

    </div>





  </div>

  <?php require "footer.php" ?>
</body>

</html>