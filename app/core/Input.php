<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Input Class
 */
class Input
{
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_get;
    
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_post;
    
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_files
;    
    /**
     * 
     * @static
     * @return void
     */
    public function __construct()
    {
        self::_detectURIString();
        
        self::$_get = $_GET;
        self::$_post = $_POST;
        self::$_files = $_FILES;
    }
    
    /**
     * 
     * @static
     * @param string $index Default is NULL
     * @return mixed Array or String
     */
    public static function get($index = NULL)
    {
        return self::_getVar('get', $index);
    }
    
    /**
     * 
     * @static
     * @param string $index Default is NULL
     * @return mixed Array or String
     */
    public static function post($index = NULL)
    {
        return self::_getVar('post', $index);
    }
    
    /**
     * 
     * @static
     * @param string $index Default is NULL
     * @return mixed Array or String
     */
    public static function files($index = NULL)
    {
        return self::_getVar('files', $index);
    }
    
    /**
     * 
     * @param string $type
     * @param string $var
     * @param mixed $value Default is NULL
     * @return void
     */
    public static function set($type, $var, $value = NULL)
    {
        if ($type == 'get')
        {
            self::$_get[$var] = $value;
        }
        else if ($type == 'post')
        {
            self::$_post[$var] = $value;
        }
    }
    
    /**
     * 
     * @access private
     * @static
     * @param string $type
     * @param string $index Default is NULL
     * @return mixed Array or String
     */
    private static function _getVar($type, $index = NULL)
    {
        if ($type == 'get')
        {
            $var = self::$_get; 
        }
        else if ($type == 'post')
        {
            $var = self::$_post; 
        }
        else if ($type == 'files')
        {
            $var = self::$_files; 
        }
        
        if ($index !== NULL)
        {
            if (isset($var[$index]))
            {
                return $var[$index];
            }
            else
            {
                return NULL;
            }
        }
        else
        {
            return $var;
        }
    }
    
    /**
     * 
     * @access private
     * @static
     * @return void
     */
    private static function _detectURIString()
    {
        if (isset($_SERVER['REQUEST_URI']))
        {
            $uri = $_SERVER['REQUEST_URI'];
            
            if (strncmp($uri, '?/', 2) === 0)
            {
                $uri = substr($uri, 2);
            }

            $parts = preg_split('#\?#i', $uri, 2);

            if (isset($parts[1]))
            {
                $_SERVER['QUERY_STRING'] = $parts[1];
                parse_str($_SERVER['QUERY_STRING'], $_GET);
            }
            else
            {
                $_SERVER['QUERY_STRING'] = '';
                $_GET = array();
            }
        }
    }
}