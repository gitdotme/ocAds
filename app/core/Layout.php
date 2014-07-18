<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Layout Class
 */
class Layout
{
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_layout_view = 'layout/vPageLayout';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_title;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_desc;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_heading;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_charset;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_robots;
    
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_css = array();
    
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_js = array();
    
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
     * @param string $view
     * @param array $data
     * @return void
     */
    public static function view($view, $data = array())
    {
        // render content
        $data['titleLayout'] = self::$_title ? self::$_title : Config::get('siteTitle', 'seo');
        $data['descLayout'] = self::$_desc ? self::$_desc : Config::get('siteDesc', 'seo');
        $data['headingLayout'] = self::$_heading ? self::$_heading : Config::get('siteHeading', 'seo');
        $data['charsetLayout'] = self::$_charset ? self::$_charset : Config::get('siteCharset', 'seo');
        $data['robotsLayout'] = self::$_robots ? self::$_robots : Config::get('siteRobots', 'seo');
        $data['ad336x280Layout'] = View::render('ad/vAd336x280', $data, TRUE);
        $data['ad336x280AltLayout'] = View::render('ad/vAd336x280Alt', $data, TRUE);
        $data['ad160x600Layout'] = View::render('ad/vAd160x600', $data, TRUE);
        $data['contentLayout'] = View::render($view, $data, TRUE);
        
        // render css
        $data['cssLayout'] = '';
        if (self::$_css)
        {
            foreach (self::$_css as $val)
            {
                $data['cssLayout'] .= '<link rel="stylesheet" type="text/css" href="'.$val.'">'."\n\t\t";
            }
        }
        
        // render js
        $data['jsLayout'] = '';
        if (self::$_js)
        {
            foreach (self::$_js as $val)
            {
                $data['jsLayout'] .= '<script type="text/javascript" src="'.$val.'"></script>'."\n\t\t";
            }
        }
        
        // render layout
        View::render(self::$_layout_view, $data);
    }
    
    /**
     * 
     * @static
     * @param string $file
     * @return void
     */
    public static function change($file)
    {
        self::$_layout_view = $file;
    }
    
    /**
     * 
     * @static
     * @param string $title
     * @return void
     */
    public static function title($title)
    {
        self::$_title = $title;
    }
    
    /**
     * 
     * @static
     * @param string $desc
     * @return void
     */
    public static function desc($desc)
    {
        self::$_desc = $desc;
    }
    
    /**
     * 
     * @static
     * @param string $desc
     * @return void
     */
    public static function heading($heading)
    {
        self::$_heading = $heading;
    }
    
    /**
     * 
     * @static
     * @param string $charset
     * @return void
     */
    public static function charset($charset)
    {
        self::$_charset = $charset;
    }
    
    /**
     * 
     * @static
     * @param string $robots
     * @return void
     */
    public static function robots($robots)
    {
        self::$_robots = $robots;
    }
    
    /**
     * 
     * @static
     * @param string $css
     * @return void
     */
    public static function css($css)
    {
        if (filter_var($css, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED))
        {
            self::$_css[] = $css;
        }
        else
        {
            self::$_css[] = baseURL($css);
        }
    }
    
    /**
     * 
     * @static
     * @param string $js
     * @return void
     */
    public static function js($js)
    {
        if (filter_var($js, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED))
        {
            self::$_js[] = $js;
        }
        else
        {
            self::$_js[] = baseURL($js);
        }
    }
}