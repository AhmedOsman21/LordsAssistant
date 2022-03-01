<?php

// Keep Value Class
class ValueKeeper
{
    // Keep Field Values.
    public function keepVals($field)
    {
        $value = "";
        if (isset($_POST[$field]) && !empty($_POST[$field])) {
            $value = htmlspecialchars($_POST[$field]);
        }
        return $value;
    }
}
