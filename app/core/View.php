<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * View Class
 */
class View
{
    /**
     * @static
     * @access private
     * @var bool
     */
    private static $_zlib = FALSE;
    
    /**
     * 
     * @access private
     * @return void
     */
    private function __construct()
    {
        // set zlib output compression
        self::$_zlib = @ini_get('zlib.output_compression');
    }
    
    /**
     * 
     * @static
     * @param string $file
     * @param array $data
     * @param bool $get_output
     * @throws Exception
     */
    public static function render($file, $data = array(), $get_output = FALSE)
    {
        try
        {
            $view_path = APP_DIR.'/views/'.$file.'.php';
            
            if (file_exists($view_path))
            {
                if ( ! empty($data))
                {
                    extract($data);
                }
                
                if (Config::get('compressOutput') AND self::$_zlib == FALSE)
                {
                    if (extension_loaded('zlib'))
                    {
                        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) AND strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE)
                        {
                            ob_start('ob_gzhandler');
                        }
                    }
                }
                else
                {
                    ob_start();
                    ob_clean();
                }
                
                require $view_path;
                
                if ($get_output)
                {
                    $output = ob_get_contents();
                    ob_end_clean();
                    
                    return $output;
                }
            }
            else
            {
                // throw exception when view file not found
                throw new Exception('View file not found: '.$file);
            }
        }
        catch (Exception $e)
        {
            // trigger caught exception
            trigger_error($e->getMessage(), E_USER_WARNING);
            
            // show error page
            showError($e->getMessage(), 'Error: View', 500);
        }
        
        return NULL;
    }
}