<?php 

// Handling url issue due to seperating tools in a seperated directory.
function urlCheck($page) {
    $filePath = explode("/", $_SERVER['PHP_SELF']);
    $fileName = $filePath[count($filePath)-1];
    $tools = array("gf.php", "kvk.php", "timezone.php");
    
    if (in_array($fileName, $tools)) {
        $link = "../" . $page;
    } else {
        $link = $page;
    }

    return $link;
}
