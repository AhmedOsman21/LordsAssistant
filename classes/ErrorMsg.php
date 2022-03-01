<?php

// Error Messages.
class ErrorMsg {
    public function errMsg($err_name) {
        if (isset($err_name)) {
            return "<p class='err'>" . $err_name . "</p>";
        } else {
            return "";
        }
    }
}