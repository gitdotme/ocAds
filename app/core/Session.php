<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Session Class
 */
class Session
{
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        session_start();
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        if (isset($_SESSION[$key]))
        {
            unset($_SESSION[$key]);
        }
        
        $_SESSION[$key] = $value;
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @return void
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        
        return NULL;
    }
    
    /**
     * 
     * @static
     * @return void
     */
    public static function destroy()
    {
        session_destroy();
    }
}