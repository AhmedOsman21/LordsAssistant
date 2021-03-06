<?php
// Abstract class for input validator class
abstract class Validation {
    abstract public function validate(string $value, string  $type): bool;
    abstract public function clean_input($input);
}

// Class to clean input data & validate it
class Validator extends Validation {
    public static $string_pattern = "/^[A-z\s]*$/";
    public static $phone_pattern = "/^(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?$/";

    /** 
     * Validate input fields based on it's input type to prevent XSS attacks
     * @param string $value Input data
     * @param string $type="" (optional) Input type i.e name, email, phone
     *
     * @return bool Whether the input value is valid or not
     */
    public function validate(string $value, string $type = ""): bool {
        $result = false;

        // Valid Names
        if (($type === "name") && preg_match(static::$string_pattern, $value)) {
            $result = true;

            // Valid E-mail
        } elseif ($type === "email" && filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $result = true;

            // Valid Phone Number
        } elseif ($type === "phone" && preg_match(static::$phone_pattern, $value)) {
            $result = true;

            // Valid Positive Integer
        } elseif ($type === "number" && filter_var($value, FILTER_VALIDATE_INT) && $value > 0) {
            $result = true;
        }

        return $result;
    }

    /**
     * Clean input data
     * @param string $input Input data
     * 
     * @return string Cleaned and sanitized version of input value.
     */
    public function clean_input($input) {
        return trim(stripslashes(htmlspecialchars($input)));
    }
}
