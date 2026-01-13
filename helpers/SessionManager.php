<?php


class SessionManager
{

    public function __construct()
    {
       
        if (session_status() === PHP_SESSION_NONE) {
            
            if (!headers_sent()) {
                session_start();
            } else {
                
                error_log('SessionManager: headers already sent; session_start() skipped.');
            }
        }
    }

    public function setAttribute($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function setSerializeAttribute($key, $value)
    {
        if (isset($_SESSION[$key])) {
            $_SESSION[$key] = serialize($value);
        }
        $_SESSION[$key] = serialize($value);
    }

    public function getUnserializeAttribute($key)
    {
        if (isset($_SESSION[$key])) {
            return unserialize($_SESSION[$key]);
        } else {
            return NULL;
        }
    }

    public function getAttribute($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return NULL;
        }
    }

    public function removeAttribute($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function isKeySet($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        } else {
            return false;
        }
    }
}
