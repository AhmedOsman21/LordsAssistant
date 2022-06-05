<?php
// Abstract class for input validator class
abstract class Validation {
    abstract public static function validate(string $value, string  $type) : bool;
    abstract protected function clean_input($input);
}
