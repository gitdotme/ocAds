<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Loader Class
 */
class Loader
{
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        require APP_DIR.'/config/loader.php';
        
        if (is_array($loader) AND ! empty($loader))
        {
            foreach ($loader as $key => $value)
            {
                if (is_array($value) AND ! empty($value))
                {
                    foreach ($value as $name)
                    {
                        self::{$key}($name);
                    }
                }
            }
        }
    }
    
    /**
     * 
     * @static
     * @param string $name
     * @return void
     */
    public static function config($name)
    {
        Config::load($name);
    }
    
    /**
     * 
     * @param string $name
     * @param bool $instance
     * @return object|null Object or NULL
     * @throws Exception
     */
    public static function core($name, $instance = TRUE)
    {
        $core_name = ucfirst($name);
        
        if ( ! class_exists($core_name))
        {
            try
            {
                $path = APP_DIR.'/core/'.$core_name.'.php';

                if (file_exists($path))
                {
                    require $path;
                    
                    if ($instance === TRUE)
                    {
                        $exclude_instance = array('View', 'Layout');
                        if (in_array($core_name, $exclude_instance))
                        {
                            return NULL;
                        }
                        
                        $instance_name = ($core_name == 'Database')
                                ? 'DB'
                                : $core_name;

                        return new $instance_name;
                    }
                }
                else
                {
                    throw new Exception('Core not found: '.$core_name);
                }
            }
            catch (Exception $e)
            {
                logMessage('error', $e->getMessage(), TRUE);

                showError($e->getMessage(), 'Error: Loader', 500);
            }
        }
        
        return NULL;
    }
    
    /**
     * 
     * @static
     * @param string $name
     * @return void
     * @throws Exception
     */
    public static function helper($name)
    {
        try
        {
            $path = APP_DIR.'/helpers/h'.ucfirst($name).'.php';
            
            if (file_exists($path))
            {
                require $path;
            }
            else
            {
                throw new Exception('Helper not found: '.$name);
            }
        }
        catch (Exception $e)
        {
            trigger_error($e->getMessage(), E_USER_WARNING);
            
            showError($e->getMessage(), 'Error: Loader', 500);
        }
    }
    
    /**
     * 
     * @static
     * @param string $name
     * @param bool $instance
     * @return object|null Object or NULL
     * @throws Exception
     */
    public static function library($name, $instance = FALSE)
    {
        if ( ! class_exists($name))
        {
            try
            {
                $path = APP_DIR.'/libs/'.$name.'.php';

                if (file_exists($path))
                {
                    require $path;

                    if ($instance === TRUE)
                    {
                        return new $name();
                    }
                }
                else
                {
                    throw new Exception('Library not found: '.$name);
                }
            }
            catch (Exception $e)
            {
                trigger_error($e->getMessage(), E_USER_WARNING);

                showError($e->getMessage(), 'Error: Loader', 500);
            }
        }
        
        return NULL;
    }
    
    /**
     * 
     * @static
     * @param string $name
     * @param bool $instance
     * @return object|null Object or NULL
     * @throws Exception
     */
    public static function model($name, $instance = TRUE)
    {
        $model_name = 'm'.ucfirst($name);
        
        if ( ! class_exists($model_name))
        {
            try
            {
                $path = APP_DIR.'/models/'.$model_name.'.php';

                if (file_exists($path))
                {
                    require $path;

                    if ($instance === TRUE)
                    {
                        return new $model_name;
                    }
                }
                else
                {
                    throw new Exception('Model not found: '.$model_name);
                }
            }
            catch (Exception $e)
            {
                trigger_error($e->getMessage(), E_USER_WARNING);

                showError($e->getMessage(), 'Error: Loader', 500);
            }
        }
        
        return NULL;
    }
}