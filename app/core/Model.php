<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Model Class
 */
class Model
{
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        // log debug message
    }
    
    /**
     * 
     * @access private
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return Controller::getInstance()->$key;
    }
}