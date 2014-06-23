<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * View Class
 */
class View
{
    /**
     * 
     * @access private
     * @return void
     */
    private function __construct()
    {
        // does not create instance
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
                //print_r($data);die;
                ob_start();
                ob_clean();
                
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