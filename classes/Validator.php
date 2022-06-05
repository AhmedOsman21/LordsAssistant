<?php
// Abstract class for input validator class
abstract class Validation {
    abstract public function validate(string $value, string  $type): bool;
    abstract protected function clean_input($input);
}

// Class to clean input data & validate it
class Validator extends Validation {

    /** 
     * Validate input fields based on it's input type to prevent XSS attacks
     * @param string $value Input data
     * @param string $type="" (optional) Input type i.e name, email, phone
     *
     * @return bool Whether the cleaned-input value is valid or not
     */
    public function validate(string $value, string $type = ""): bool {
        // Cleaning the input value
        $input = $this->clean_input($value);
        $string_pattern = "/^[A-z\s]*$/";
        $phone_pattern = "/^(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?$/";
        $result = false;


        // Valid general input
        if ($type === "") {
            $result = true;

        // Valid Name
        } elseif (($type === "name") && preg_match($string_pattern, $input)) {
            $result = true;

            // Valid E-mail
        } elseif ($type === "email" && filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $result = true;

            // Valid Phone Number
        } elseif ($type === "phone" && preg_match($phone_pattern, $input)) {
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
    protected function clean_input($input) {
        return trim(stripslashes(htmlspecialchars($input)));
    }
}
