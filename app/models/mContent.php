<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Content Model
 */
class mContent extends Model
{
    public function __construct()
    {
        parent::__construct();
        
        Loader::helper('PHPMailer');
    }
    
    public function sendMessage($sendData)
    {
        $from = array(
            'name' => Config::get('senderName'),
            'email' => Config::get('senderEmail')
        );
        
        $to = Config::get('contactEmail');
        
        $replyTo = array(
            'name' => $sendData['name'],
            'email' => $sendData['email']
        );
        
        $subject = 'Contact';
        
        $body = View::render('content/email/vContactTpl', $sendData, TRUE);
       
        if (mailSend($from, $to, $replyTo, $subject, $body))
        {
            Form::reset();
            
            return array(
                'success' => TRUE,
                'result' => 'Your message has been sent.'
            );
        }
        else
        {
            return array(
                'success' => FALSE,
                'result' => 'An error occurred while sending.'
            );
        }
    }
}