<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Item Controller
 */
class cItem extends Controller
{
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->loadModel('item');
        
        Loader::library('API', TRUE);
        Loader::library('Curl');
    }
    
    /**
     * 
     * @param string $id
     * @return void
     */
    public function index($id)
    {
        $item = $this->mItem->getItem($id);
        if ( ! $item)
        {
            showError('The classified of ad does not exist.', 'Not Found', 404);
        }
        
        redirect($item->link);
    }
}