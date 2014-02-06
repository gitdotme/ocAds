<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

 /**
  * Curl Library
  */
class Curl
{
    public static $callback = FALSE;
    public static $secure = FALSE;
    public static $cookie_path = '';
    public static $cookie_file = 'cookie.txt';
    public static $header = FALSE;
    public static $http_status = FALSE;
    public static $send_header = FALSE;
    public static $cookie = FALSE;
    public static $follow = TRUE;
    public static $transfer = TRUE;
    public static $referer = FALSE;
    public static $useragent = 'ocAds (+http://www.ocads.org)';
    public static $proxy = FALSE;
    public static $proxyport = FALSE;
    public static $timeout = 30;
    private static $_conn;
    
    /**
     * 
     * @return void
     */
    private function __construct()
    {
        // nothing to do
    }
    
    /**
     * 
     * @static
     * @param string $file Default is NULL
     * @return void
     */
    public static function init($file = NULL)
    {
        self::$_conn = curl_init();
        
        if ($file !== NULL)
        {
            $file = md5(time().rand(0, 100000));
        }
        
        self::$cookie_file = self::$cookie_path.'/'.$file;
    }

    /**
     * 
     * @static
     * @param string $url
     * @return mixed
     */
    public static function get($url)
    {
        return self::doRequest('GET', $url);
    }
    
    /**
     * 
     * @static
     * @param string $url
     * @param array $params
     * @return mixed
     */
    public static function post($url, $params = array())
    {
        $post_data = '';
        
        if ($params)
        {
            foreach($params as $key => $val)
            {
                if ( ! $post_data)
                {
                    $post_data .= '&';
                }
                
                $post_data.= $key.'='.urlencode($val);
            }
        }
        
        return self::doRequest('POST', $url, $post_data);
    }
    
    /**
     * 
     * @access private
     * @static
     * @param string $method
     * @param string $url
     * @param array $vars
     * @return mixed|null
     */
    private static function doRequest($method, $url, $vars = array())
    {
        curl_setopt(self::$_conn, CURLOPT_URL, $url);
        curl_setopt(self::$_conn, CURLOPT_TIMEOUT, self::$timeout);
        
        if (self::$header)
        {
            curl_setopt(self::$_conn, CURLOPT_HEADER, 1);
        }
        else
        {
            curl_setopt(self::$_conn, CURLOPT_HEADER, 0);
        }
        
        if (is_array(self::$send_header))
        {
            curl_setopt(self::$_conn, CURLOPT_HTTPHEADER, self::$send_header);
        }
        
        curl_setopt(self::$_conn, CURLOPT_USERAGENT, self::$useragent);
        
        if (self::$secure)
        {
            curl_setopt(self::$_conn, CURLOPT_SSL_VERIFYHOST,  0);
            curl_setopt(self::$_conn, CURLOPT_SSL_VERIFYPEER, 0);
        }
        
        if (self::$cookie) 
        {
            curl_setopt(self::$_conn, CURLOPT_COOKIE, self::$cookie);
            curl_setopt(self::$_conn, CURLOPT_COOKIEJAR, self::$cookie_file);
            curl_setopt(self::$_conn, CURLOPT_COOKIEFILE, self::$cookie_file);
        }
        
        if (self::$follow)
        {
            curl_setopt(self::$_conn, CURLOPT_FOLLOWLOCATION, 1);
        }
        else
        {
            curl_setopt(self::$_conn, CURLOPT_FOLLOWLOCATION, 0);
        }
        
        if (self::$referer)
        {
            curl_setopt(self::$_conn, CURLOPT_REFERER, self::$referer);
        }
        
        if (self::$proxy)
        {
            curl_setopt(self::$_conn, CURLOPT_PROXY, self::$proxy);
            curl_setopt(self::$_conn, CURLOPT_PROXYPORT, self::$proxyport);
        }
        
        if (self::$transfer)
        {
            curl_setopt(self::$_conn, CURLOPT_RETURNTRANSFER, 1);
        }
        else
        {
            curl_setopt(self::$_conn, CURLOPT_RETURNTRANSFER, 0);
        }
        
        if ($method == 'POST')
        {
            curl_setopt(self::$_conn, CURLOPT_POST, 1);
            curl_setopt(self::$_conn, CURLOPT_POSTFIELDS, $vars);
            curl_setopt(self::$_conn, CURLOPT_HTTPHEADER, array('Expect: ')); // lighttpd fix
        }
        
        $data = curl_exec(self::$_conn);
        
        self::$http_status = curl_getinfo(self::$_conn, CURLINFO_HTTP_CODE);
        
        if ($data)
        {
            return $data;
        }
        
        return NULL;
    }
    
    /**
     * 
     * @static
     * @return string
     */
    public static function getError()
    {
        return curl_error(self::$_conn);
    }
    
    /**
     * 
     * @static
     * @return void
     */
    public static function close()
    {
        curl_close(self::$_conn);
        
        if (is_file(self::$cookie_file))
        {
            unlink(self::$cookie_file);
        }
    }
}