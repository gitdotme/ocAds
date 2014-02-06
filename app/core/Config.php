<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Config Class
 */
class Config
{
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_config = array();
    
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        // load default config
        self::load();
    }
    
    /**
     * 
     * @static
     * @param string $file
     * @return void
     */
    public static function load($file = 'config')
    {
        try
        {
            $path = APP_DIR.'/config/'.$file.'.php';
            
            if (file_exists($path))
            {
                require $path;
                
                if (is_array($config) AND ! empty($config))
                {
                    foreach ($config as $key => $value)
                    {
                        self::set($key, $value, $file);
                    }
                }
                else
                {
                    throw new Exception('Config file not found: '.$path);
                }
            }
        }
        catch (Exception $e)
        {
            logMessage('error', $e->getMessage(), TRUE);

            showError($e->getMessage(), 'Error: Config', 500);
        }
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param mixed $value String, Integer or Array
     * @param string $index
     * @return void
     * 
     */
    public static function set($key, $value, $index = 'config')
    {
        self::$_config[$index][$key] = $value;
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $index
     * @return string
     */
    public static function get($key, $index = 'config')
    {
        if (isset(self::$_config[$index][$key]))
        {
            return self::$_config[$index][$key];
        }
        
        return NULL;
    }
}