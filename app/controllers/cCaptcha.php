<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Captcha Controller
 */
class cCaptcha extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        Loader::library('Captcha');
    }
    
    /**
     * 
     * @return void
     */
    public function index()
    {
        header('Content-Type: image/gif; charset=UTF-8');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: max-age=0, post-check=0, pre-check=0');
        header('Pragma: no-cache');
        
        Captcha::show();
    }
}