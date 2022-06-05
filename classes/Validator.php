<?php
// Abstract class for input validator class
abstract class Validation {
    abstract public function validate(string $value, string  $type) : bool;
    abstract protected function clean_input($input);
    abstract protected function format_name($name);
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
    public function validate(string $value, string $type="") : bool {

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
