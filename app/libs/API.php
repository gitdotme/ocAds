<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * API Library
 */
class API
{
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_apiUrl = 'http://git.me/api';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_apiKey = '';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_params = '';
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_resultsLimit = 10;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_total = 0;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_count = 0;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_page = 1;
    
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        self::$_apiKey = Config::get('apiKey');
    }
    
    /**
     * 
     * @static
     * @return int
     */
    public static function getResultsLimit()
    {
        return self::$_resultsLimit;
    }
    
    /**
     * 
     * @static
     * @return int
     */
    public static function getTotal()
    {
        return self::$_total;
    }
    
    /**
     * 
     * @static
     * @param array $params
     * @return void
     */
    public static function setParams($params)
    {
        self::$_params = 'key='.self::$_apiKey.'&';
        
        if ($params)
        {
            $params['type'] = Config::get('searchType', 'search') ? Config::get('searchType', 'search') : $params['type'];
            $params['country'] = Config::get('searchCountry', 'search') ? Config::get('searchCountry', 'search') : $params['country'];
            $params['make'] = Config::get('searchMake', 'search') ? Config::get('searchMake', 'search') : $params['make'];
            $params['model'] = Config::get('searchModel', 'search') ? Config::get('searchModel', 'search') : $params['model'];
            $params['state'] = Config::get('searchState', 'search') ? Config::get('searchState', 'search') : $params['state'];
            $params['city'] = Config::get('searchCity', 'search') ? Config::get('searchCity', 'search') : $params['city'];
            
            foreach ($params as $param => $val)
            {
                if ($param == 'page')
                {
                    if (isset($val) && $val !== '')
                    {
                        self::$_page = $val;
                    }
                }
                else
                {
                    self::$_params .= $param.'='.urlencode(str_replace("'", ' ', $val)).'&';
                }
            }
        }
        
        self::$_resultsLimit = Config::get('searchResultsLimit', 'limit');
        self::$_params .= 'limit='.self::$_resultsLimit.'&page='.self::$_page;
    }
    
    /**
     * 
     * @static
     * @param int $limit Default is NULL
     * @return object|null
     */
    public static function search($limit = NULL)
    {
        if ($limit !== NULL)
        {
            self::$_params = str_replace('&limit='.self::$_resultsLimit, '&limit='.$limit, self::$_params);
        }
        
        Curl::init();
        
        $jsonGet = Curl::get(self::$_apiUrl.'/search?'.self::$_params);
        
        Curl::close();
        
        if ( $jsonGet )
        {
            $jsonData = json_decode($jsonGet);
            if (isset($jsonData->error))
            {
                showError($jsonData->error, 'API Error', 500);
            }
            else
            {
                self::$_total = $jsonData->total;
                
                return $jsonData->items;
            }
        }
        
        return NULL;
    }
    
    /**
     * 
     * @static
     * @param string $id
     * @return object|null
     */
    public static function item($id)
    {
        self::$_params = 'key='.self::$_apiKey.'&id='.$id;
        
        Curl::init();
        
        $jsonGet = Curl::get(self::$_apiUrl.'/item?'.self::$_params);
        
        Curl::close();
        
        if ($jsonGet)
        {
            $jsonData = json_decode($jsonGet);
            if (isset($jsonData->error))
            {
                showError($jsonData->error, 'API Error', 500);
            }
            else
            {
                return $jsonData;
            }
        }
        
        return NULL;
    }
}