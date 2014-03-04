<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Content Controller
 */
class cContent extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        Layout::css('assets/css/common.css');
        Layout::js('assets/js/jquery.min.js');
        Layout::js('assets/js/jquery.placeholder.js');
        Layout::js('assets/js/common.js');
    }
    
    /**
     * 
     * @return void
     */
    public function about()
    {
        $data['sidebarLayout'] = View::render('content/vSidebar', array('page' => 'about'), TRUE);
        
        Layout::title('About Us');
        Layout::desc('About Us');
        Layout::view('content/vAbout', $data);
    }
    
    /**
     * 
     * @return void
     */
    public function privacy()
    {
        $data['sidebarLayout'] = View::render('content/vSidebar', array('page' => 'privacy'), TRUE);
        
        Layout::title('Privacy Policy');
        Layout::desc('Privacy Policy');
        Layout::view('content/vPrivacy', $data);
    }
    
    /**
     * 
     * @return void
     */
    public function terms()
    {
        $data['sidebarLayout'] = View::render('content/vSidebar', array('page' => 'terms'), TRUE);
        
        Layout::title('Terms of Use');
        Layout::desc('Terms of Use');
        Layout::view('content/vTerms', $data);
    }
    
    /**
     * 
     * @return void
     */
    public function contact()
    {
        $this->loadModel('content');
        
        Loader::library('Form');
        
        $data = array();
        
        if (Input::post())
        {
            Form::rule('name', 'trim|required|alpha|maxLength:100');
            Form::rule('email', 'trim|required|validEmail|maxLength:100');
            Form::rule('message', 'trim|required|maxLength:5000');
            Form::rule('captcha', 'trim|required|numeric|verifyCaptcha');
            
            if (Form::run() === TRUE)
            {
                $sendData = array (
                        'name' => Input::post('name'),
                        'email' => Input::post('email'),
                        'message' => Input::post('message')
                );
                
                $data = $this->mContent->sendMessage($sendData);
            }
            else
            {
                $data = array(
                    'success' => FALSE,
                    'result' => Form::errors()
                );
            }
        }
        
        $data['sidebarLayout'] = View::render('content/vSidebar', array('page' => 'contact'), TRUE);
        
        Layout::title('Contact');
        Layout::desc('Contact us.');
        Layout::view('content/vContact', $data);
    }
}