<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Route Class
 */
class Route
{
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_request = NULL;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_controller = NULL;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_method = NULL;
    
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_args = array();
    
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_config = array();
    
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        self::$_request = self::_getRequest();
        
        require APP_DIR.'/config/route.php';
        
        if (isset($route) AND is_array($route) AND ! empty($route))
        {
            foreach ($route as $key => $value)
            {
                if (isset($value['route']) AND isset($value['method']))
                {
                    if ( ! self::$_controller )
                    {
                        self::_check($value['route'], $value['method']);
                    }
                    
                    self::_set_config($key, $value['route'], $value['method']);
                }
            }
        }
        
        if ( ! self::$_controller)
        {
            self::_parseRequest();
        }
    }
    
    /**
     * 
     * @access private
     * @static
     * @return string
     */
    private static function _getRequest()
    {
        if ( ! Config::get('baseURL'))
        {
            showError('The baseURL is not defined on config file.', 'baseURL Not Defined', 500);
        }
        
        $url_path = parse_url(baseURL(), PHP_URL_PATH);
        $request = ltrim(rtrim(str_replace($url_path, '', $_SERVER['REQUEST_URI']), '/'), '/');
        
        return $request;
    }
    
    /**
     * 
     * @access private
     * @static
     * @param string $regex
     * @param string $route
     * @return void
     */
    private static function _check($regex, $route)
    {
        if (strpos(self::$_request, '?') !== FALSE)
        {
            self::$_request = rtrim(strstr(self::$_request, '?', TRUE), '/');
        }
        
        $pattern = preg_replace('/{([\w]+)}/Uis', '([\w-]+)', $regex);
        $pattern = str_replace('/', '\\/', $pattern);
        
        if (preg_match('#^'.$pattern.'$#', self::$_request, $vals))
        {
            if (strpos($route, '@') !== FALSE)
            {
                self::$_controller = 'c'.ucfirst(strstr($route, '@', TRUE));
                self::$_method = substr(strstr($route, '@'), 1);
            }
            else
            {
                self::$_controller = 'c'.ucfirst($route);
                self::$_method = 'index';
            }
            
            preg_match_all('/{([\w]+)}/Uis', $regex, $vars);
            if ($vars[1])
            {
                $row = 1;
                foreach ($vars[1] as $arg_var)
                {
                    self::$_args[$arg_var] = $vals[$row];
                    
                    $row++;
                }
            }
        }
    }
    
    /**
     * 
     * @access private
     * @static
     * @return void
     */
    private static function _parseRequest()
    {
        $parse = explode('/', self::$_request);
        
        if (self::$_request AND $parse)
        {
            for ($i = 0; $i < count($parse); $i++)
            {
                if ($i == 0)
                {
                    self::$_controller = 'c'.ucfirst($parse[$i]);
                }
                else if ($i == 1)
                {
                    self::$_method = $parse[$i];
                }
                else
                {
                    self::$_args[] = $parse[$i];
                }
            }
        }
        else
        {
            self::$_controller = 'c'.ucfirst(Config::get('defaultController'));
        }
        
        if ( ! self::$_method)
        {
            self::$_method = 'index';
        }
    }
    
    /**
     * @static
     * @return string
     */
    public static function get($item)
    {
        switch ($item)
        {
            case 'request':
                return self::$_request;
                break;
            
            case 'controller':
                return self::$_controller;
                break;
            
            case 'method':
                return self::$_method;
                break;
            
            case 'args':
                return self::$_args;
                break;
        }
    }
    
    /**
     * 
     * @param string $item
     * @param string $route
     * @param string $method
     */
    private static function _set_config($item, $route, $method)
    {
        self::$_config[$item] = array(
            'route' => $route,
            'method' => $method
        );
    }
    
    /**
     * 
     * @param string $item
     * @param string $type
     * @return string|null
     */
    public static function get_config($item, $type)
    {
        if (isset(self::$_config[$item][$type]))
        {
            return self::$_config[$item][$type];
        }
        
        return NULL;
    }
}