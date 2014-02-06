<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * 
 * Bootstrap Class
 */
class Bootstrap
{
    /**
     *
     * @access private
     * @var string
     */
    private $_request;
    
    /**
     *
     * @access private
     * @var string
     */
    private $_controller;
    
    /**
     *
     * @access private
     * @var string
     */
    private $_method;
    
    /**
     *
     * @access private
     * @var array
     */
    private $_args = array();
    
    /**
     * 
     * @throws Exception
     * @return void
     */
    public function __construct()
    {
        // set route variables
        $this->_setRouteVars();
        
        // load controller
        $this->_loadController();
    }
    
    /**
     * 
     * @access private
     * @return void
     */
    private function _setRouteVars()
    {
        // set request from route
        $this->_request = Route::get('request');
        
        // set controller from route
        $this->_controller = Route::get('controller');
        
        // set method from route
        $this->_method = Route::get('method');
        
        // set args from route
        $this->_args = Route::get('args');
    }
    
    /**
     * 
     * @throws Exception
     * @return void
     */
    private function _loadController()
    {
        try
        {
            // set controller path
            $cont_path = APP_DIR.'/controllers/'.$this->_controller.'.php';
            
            // check if controller exists
            if (file_exists($cont_path))
            {
                // load controller
                require $cont_path;
                
                // create instance from loaded controller
                $controller = new $this->_controller();
                
                // check if method exists
                if (method_exists($controller, $this->_method))
                {
                    // order args
                    $this->_orderArgs();
                    
                    // call controller method with args
                    call_user_func_array(array($controller, $this->_method), $this->_args);
                }
                else
                {
                    // throw exception when method does not exist
                    throw new Exception('Method not found: '.$this->_controller.'@'.$this->_method);
                }
            }
            else
            {
                // throw exception when controller does not exist
                throw new Exception('404 Page Not Found: '.$this->_request);
            }
        }
        catch (Exception $e)
        {
            // trigger error when caught exception
            logMessage('error', $e->getMessage());
            
            // show error page
            showError();
        }
    }
    
    /**
     * 
     * @access private
     * @return void
     */
    private function _orderArgs()
    {
        // exit if args is null
        if ( ! $this->_args)
        {
            return;
        }
        
        // set temp args var
        $tmp_args = $this->_args;
        
        // reset args array
        $this->_args = array();
        
        // instance reflection method
        $ref = new ReflectionMethod($this->_controller, $this->_method);
        
        // get parameters of method
        $params = $ref->getParameters();
        
        foreach ($params as $param)
        {
            // get arg name
            $arg_name = $param->getName();
            
            // check if arg exists on temp args
            if (isset($tmp_args[$arg_name]))
            {
                // push new item to args array
                $this->_args[] = $tmp_args[$arg_name];
            }
            else
            {
                // push null item if arg does not exist on args array
                $this->_args[] = NULL;
            }
        }
    }
    
    /**
     * 
     * @return void
     */
    public function __destruct()
    {
        // close database connection
        DB::close();
    }
}