<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Controller Class
 * 
 * @property mHome $mHome
 * @property mSearch $mSearch
 * @property mItem $mItem
 */
class Controller
{
    /**
     *
     * @access private
     * @static
     * @var object
     */
    private static $_instance;
    
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        self::$_instance =& $this;
    }
    
    /**
     * 
     * @static
     * @return object
     */
    public static function &getInstance()
    {
        return self::$_instance;
    }
    
    /**
     * 
     * @param string $name
     * @return void
     */
    public function loadModel($name)
    {
        $model = Loader::model($name);
        
        if ($model !== NULL)
        {
            $this->{get_class($model)} = $model;
        }
    }
}