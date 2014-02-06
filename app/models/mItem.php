<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Item Model
 */
class mItem extends Model
{
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 
     * @return object|null
     */
    public function getItem($id)
    {
        return API::item($id);
    }
}