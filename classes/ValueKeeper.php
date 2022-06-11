<?php

// Keep Value Class
class ValueKeeper {
    
    private static $value = "";

    /**
     * Keep Fields' Input Values When An Error Occur.
     * @param string Name of input field.
     * 
     * @return string 
    */
    public static function keepVals($field)
    {
        if (isset($_POST[$field])) {
            static::$value = htmlspecialchars($_POST[$field]);
        }
        return static::$value;
    }

    /**
     * Keep The Selected Option Set When An Error Occur.
     * @param string Name of select element.
     * 
     * @param string Value of the option element
     * 
     * @return string 
    */
    public static function keepSelection($selection, $option_value) {
        if ($selection == $option_value) {
            return "selected";
        }
    }
}
