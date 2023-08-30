<?php
class Session
{
    // Whenever you work with session
    // You have to start the session
    // With that PHP will know that
    // You are working with session
    // A static keyword means a method
    // or properties can be called without
    // creating an instance of a class
    // You use static keyword if it doesn't
    // depend on any of the properties
    // and variables of the class
    public static function start()
    {
        if (empty($_SESSION["start"])) {
            // If session is empty
            // Then start the session
            session_start();
        }
    }

    // Store the values in the session
    // When you called this method 
    // The session will hold the details 
    // of the user that is currently login
    // And the session name will be active user
    public static function set($session_name, $value)
    {
        $_SESSION[$session_name] = $value;
    }

    // Method that will accessed or get
    // $_SESSION[$session_name]
    public static function get($session_name)
    {
        if (isset($_SESSION[$session_name])) {
            return $_SESSION[$session_name];
        } else {
            return false;
        }
    }

    // Destroy the session
    // This method is called 
    // when the user logout
    public static function destroy($session_name)
    {
        if (isset($_SESSION[$session_name])) {
            unset($_SESSION[$session_name]);
        }
    }

    // Method to check if the session exist
    public static function exist($session_name)
    {
        if (!isset($_SESSION[$session_name])) {
            return false;
        } else {
            return true;
        }
    }
}
