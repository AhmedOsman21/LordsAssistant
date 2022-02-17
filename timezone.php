<?php

// Make timezone downlists.
function timezones_downlist($name)
{
    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    // Array to hold timezone id as a key and city name as a value.
    $tz_cities = [];
    // Looping timezone identifiers list.
    foreach ($tzlist as $value) {
        // Make city name out of timeozone id.
        $city_pos = strpos($value, '/') + 1;
        $city = substr($value, $city_pos);
        // $city = str_replace("/", " - ", $city);
        $city = strtr($city, '/', ' - ');
        $tz_cities[$value] = $city;
    }
    
    // Sort cities alphabetically to make timezone list user-friendly.
    asort($tz_cities);
    
    $select = "<select class='form-select' aria-label='Default select example' id='timezone' name='$name' autofocus>";
    echo $select;
    echo "<option value=''>--</option>";
    // Adding id as a value to option elements & city name as a content.
    foreach ($tz_cities as $tz => $city) {
        $opt = '<option value=' . $tz . '>' . $city . '</option>';
        echo $opt;
    }
    echo "<select>";
}





// Include output card file to import Card Function.
include "output_card.php";

$ouput = "";
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Required timezone.
    $target_tz = $_POST['timezone'];

    // No empty choices.
    if (!empty($target_tz)) {
        // Seperating timezone id to an array.
        $tz_seperator = explode("/", $target_tz);
        // Get more specified location.
        $tz_len = count($tz_seperator);
        $local_area = "";
        switch (true) {
            case ($tz_len === 2):
                $local_area .= $tz_seperator[1];
                break;
            case ($z_len > 2):
                $local_area .= $tz_seperator[$tz_len - 2] .", ". $tz_seperator[$tz_len - 1];
        }
        // if ($tz_len === 2) {
        //     $local_area .= $tz_seperator[1];
        // } else if ($tz_len > 2) {
        //     $local_area .= $tz_seperator[$tz_len - 2] .", ". $tz_seperator[$tz_len - 1];
        // }
        $city_name = $local_area;
        // Set timezone to the desired city.
        date_default_timezone_set($target_tz);
        // Get date and time.
        $tz_date = date("l d F");
        $tz_time = date("h:i A");


        // Output Card 
        $area_format = strtr($target_tz, '/', ', ');
        // $area_format = str_replace("/", ", ", $target_tz);
        $card_head = "Time in <strong style='color: var(--bs-white)'>$city_name</strong>";
        $card_subhead = "<span style='color: var(--bs-white)'>$tz_time</span>";
        $card_content = "<span style='color: var(--bs-white)'>$tz_date <br>" . $area_format . "</span>";
        $output = card($card_head, $card_subhead, "bg-success", "text-white", $card_content);
    } else {
        $output = card("Oops!", "No selected timezone", "bg-danger", "text-white", "Please, select the timezone you want first.");
    }
}

?>



<!-- StyleSheet Name -->
<?php $style = 'forms' ?>

<?php include "header.php" ?>

<body>
    <?php include "nav.php" ?>







    <!-- Page Content -->
    <div class="container main-container">
        <div class="row mt-5 mb-3 heading">
            <h2><span><img src="images/timezone/time_icon.png" alt="time icon" width="35" height="35"></span> Timezone</h2>
        </div>

        <!-- Notificaiton -->
        <div class="row">
            <div class="description alert alert-success alert-dismissible fade show" role="alert">
                Know what's the time right now in your guild or friend's country!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <!-- Return Result -->
        <div class="result">
            <?php
            if (isset($output)) {
                echo $output;
            }
            ?>
        </div>

        <!-- Calculator Form -->
        <div class="row form-container">
            <form class="row g-3 mb-5" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

                <!-- Total Points -->
                <div class="col col-sm-12 col col-sm-12-sm-12 points">

                    <div>
                        <label for="timezone" class="form-label">Friend's Timezone</label>
                        <?php timezones_downlist("timezone") ?>
                    </div>

                    <div class="col col-sm-12-12 submit">
                        <button type="submit" class="btn submit-btn btn-success">Get Time</button>
                    </div>
                </div>
            </form>
        </div>
    </div>















    <?php require "footer.php" ?>

</body>

</html>