<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Captcha Library
 */
class Captcha
{
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_width = 80;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_height = 32;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_fontSize = 16;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_positionX = 10;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_positionY = 25;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_fontPath = 'assets/fonts/verdana.ttf';
    
    /**
     *
     * @access private
     * @static
     * @var object
     */
    private static $_image;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_sessionName = 'captcha';
    
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        // nothing to do
    }
    
    /**
     * 
     * @return void
     */
    public static function show()
    {
        self::$_image = imagecreate(self::$_width,self::$_height);
        
        $white = imagecolorallocate(self::$_image, 255, 255, 255);
        $black = imagecolorallocate(self::$_image, 0, 0, 0);
        
        imagefill(self::$_image, 0, 0, $white);
        
        for ($i = 0; $i < 20; $i++)
        {
            $pos_x  = rand(0,144);
            $pos_y  = rand(0,32);
            $width  = rand(3,100);
            $height = rand(3,100);
            $color  = imagecolorallocate(self::$_image, rand(200,255), rand(200,255), rand(200,255));
            imagefilledellipse(self::$_image, $pos_x, $pos_y, $width, $height, $color);
        }
        
        $rand = mt_rand();
        $code = substr($rand, 2, 2) . substr($rand, -3);
        
        Session::set(self::$_sessionName, $code);
        
        imagettftext(self::$_image, self::$_fontSize, 1, self::$_positionX, self::$_positionY, $black, self::$_fontPath, $code);
        imagegif(self::$_image);
        imagedestroy(self::$_image);
    }
}