<?php
// Stylesheet Name
$style = 'forms';

// Import Autoloader
require_once "../autoloader.php";

// Include output card file to import Card Function.
require_once "output_card.php";

// Resources types & Points per 1000 rss gathering.
$rss_types = array(
    "food" => 120,
    "stone" => 180,
    "timber" => 180,
    "ore" => 240,
    "gold" => 330
);

// Resourse amount you should gather.
$rss_amount = 0;

// Calculation Function 
function calc($rss_types, $rss_type, $pts) {
    global $rss_amount;
    $rss_pts = $rss_types[$rss_type];
    for ($i = 0; $i < $pts; $i += $rss_pts) {
        $rss_amount += 1000;
    }
    return $rss_amount;
}

$validator = new Validator;

$points_err = '';
$rss_type_err = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Validate Points
    if (empty($_POST['remain_pts'])) {
        $points_err = 'Please, enter your remain points to calculate.';
        // Invalid number.
    } elseif (!$validator->validate($_POST['remain_pts'], 'number')) {
        $points_err = 'You should type a valid number.';
        // Valid points.
    } else {
        $points = +$validator->clean_input($_POST['remain_pts']);
    }

    // Validate RSS Type
    if (!isset($_POST['rss_type'])) {
        $rss_type_err = 'Cannot proceed without choosing a resource type.';
    } else {
        $rss_type = $_POST['rss_type'];
    }

    // No Errors
    if (!$points_err && !$rss_type_err) {
        $result = number_format(calc($rss_types, $rss_type, $points), 0, '', ',');
        $res_txt = "<strong style='color: var(--bs-success)'>" . $result . "</strong>";
        $output = card("Result", "You have to gather", "bg-dark", "text-white", "$res_txt $rss_type to finish the given points.");
    }
}


?>

<!-- Header -->
<?php include "../include/header.php" ?>


<body>
    <!-- Navbar -->
    <?php include "../include/nav.php" ?>

    <!-- Main Container -->
    <div class="container main-container">
        <div class="row mt-5 mb-3 heading">
            <h2><span><img src="<?php echo urlCheck("images/kvk/kvk.png"); ?>" alt="kingdom clash icon"></span> Kingdom Clash Calculator</h2>
        </div>

        <!-- Notificaiton -->
        <div class="row">
            <div class="description alert alert-success alert-dismissible fade show" role="alert">
                know how much resources you should gather to get your KVK done!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <!-- Result Card -->
        <div class="result">
            <?php
            if (isset($output)) {
                echo $output;
            }
            ?>
        </div>

        <!-- Calculator Form -->
        <div class="row form-container">
            <form class="row g-3 mb-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                <!-- Total Points -->
                <div class="col col-sm-12 col col-sm-12-sm-12 points">
                    <span class="pts-icon"><img src="<?php echo urlCheck("images/kvk/points.webp"); ?>" alt="points icon" width="20" height="20"></span>
                    <label for="remain-points" class="form-label">Points Remain</label>
                    <input type="text" class="form-control" id="remain-points" name="remain_pts" placeholder="Required points">
                    <span class="err"><?= $points_err ?></span>
                </div>

                <!-- Resources Type -->
                <div>
                    <div class="gl row">
                        <div class="form-label">Resources Type</div>
                        <!-- Options -->
                        <div class="options row">
                            <!-- Food -->
                            <div class="form-check col-md-4 col-sm-12">
                                <input class="form-check-input" type="radio" name="rss_type" id="food" value="food">
                                <label class="form-check-label" for="food">
                                    <span><img src="<?php echo urlCheck("images/kvk/food.png"); ?>" alt="Food icon" width='20' height='20'></span>
                                    Food
                                </label>
                            </div>
                            <!-- Stone -->
                            <div class="form-check col-md-4 col-sm-12">
                                <input class="form-check-input" type="radio" name="rss_type" id="stone" value="stone">
                                <label class="form-check-label" for="stone">
                                    <span><img src="<?php echo urlCheck("images/kvk/stone.png"); ?>" alt="Stone icon" width='20' height='20'></span>
                                    Stone
                                </label>
                            </div>

                            <!-- Timber -->
                            <div class="form-check col-md-4 col-sm-12">
                                <input class="form-check-input" type="radio" name="rss_type" id="timber" value="timber">
                                <label class="form-check-label" for="timber">
                                    <span><img src="<?php echo urlCheck("images/kvk/timber.png"); ?>" alt="Timber icon" width='20' height='20'></span>
                                    Timber
                                </label>
                            </div>

                            <!-- Ore -->
                            <div class="form-check col-md-4 col-sm-12">
                                <input class="form-check-input" type="radio" name="rss_type" id="ore" value="ore">
                                <label class="form-check-label" for="ore">
                                    <span><img src="<?php echo urlCheck("images/kvk/ore.png"); ?>" alt="Ore icon" width='20' height='20'></span>
                                    Ore
                                </label>
                            </div>

                            <!-- Gold -->
                            <div class="form-check col-md-4 col-sm-12">
                                <input class="form-check-input" type="radio" name="rss_type" id="gold" value="gold" checked>
                                <label class="form-check-label" for="gold">
                                    <span><img src="<?php echo urlCheck("images/kvk/gold.png"); ?>" alt="Gold icon" width='20' height='20'></span>
                                    Gold
                                </label>
                            </div>
                        </div>
                        <span class="err"><?= $rss_type_err ?></span>
                    </div>
                </div>

                <!-- Calculate Button -->
                <div class="col col-sm-12-12 submit">
                    <button type="submit" class="btn submit-btn btn-success">Calculate</button>
                </div>
            </form>
        </div>

    </div>

    <!-- Footer -->
    <?php require "../include/footer.php" ?>
</body>

</html>