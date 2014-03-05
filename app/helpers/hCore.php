<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * 
 * Core Functions
 */
if ( ! function_exists('logMessage'))
{
    /**
     * 
     * @param string $level
     * @param string $message
     * @param bool $triggerError Default is FALSE
     * @return void
     */
    function logMessage($level = 'error', $message, $triggerError = FALSE)
    {
        $logThreshold = Config::get('logThreshold');
        if ( ! $logThreshold)
        {
            return;
        }
        
        $levels = array(
            'debug' => 1,
            'error' => 2,
            'all' => 3
        );
        
        if ( ! isset($levels[$level]) OR ($levels[$level] > $logThreshold))
        {
            return;
        }
        
        $msg = '';
        
        $log_path = APP_DIR.'/logs/log_'.date('Y-m-d').'.php';
        if ( ! file_exists($log_path))
        {
            $msg .= "<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!'); ?>\n\n";
        }
        
        if ( ! $file = fopen($log_path, 'a+'))
        {
             return;
        }
        
        $msg .= '['.strtoupper($level).'] '.date('r'). ' -> '.$message."\n";
        
        fwrite($file, $msg);
        fclose($file);
        
        if ($triggerError === TRUE)
        {
            trigger_error($message, E_USER_WARNING);
        }
    }
}

if ( ! function_exists('showError'))
{
    /**
     * 
     * @param string $message
     * @param string $heading
     * @param int $status
     */
    function showError($message = NULL, $heading = NULL, $status = 404)
    {
        // set http status
        http_response_code($status);
        
        // set view data
        $data = array(
            'message' => $message ? $message : 'The page that you requested not found.',
            'heading' => $heading ? $heading : 'Page Not Found'
        );
        
        // clear before
        @ob_clean();
        
        // load core classes if has not loaded before
        Loader::core('Config');
        Loader::core('View');
        Loader::core('Layout');
        
        // render template
        Layout::change('layout/vErrorLayout');
        Layout::view('error/vError', $data);
        
        // exit script
        exit;
    }
}

if ( ! function_exists('http_response_code'))
{
    /**
     * 
     * @param int $code Default is NULL
     * @return int
     */
    function http_response_code($code = NULL)
    {
        if ($code !== NULL)
        {
            switch ($code)
            {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;

                default:
                    showError('Unknown http status code: '.htmlentities($code), NULL, 500);
                    break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL'])
                    ? $_SERVER['SERVER_PROTOCOL']
                    : 'HTTP/1.0');

            header($protocol. ' '.$code.' '.$text);

            $GLOBALS['http_response_code'] = $code;

        }
        else
        {
            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
        }

        return $code;
    }
}

if ( ! function_exists('baseURL'))
{
    /**
     * 
     * @param string $url Default is NULL
     * @return strıng
     */
    function baseURL($url = NULL)
    {
        // load config core if has not loaded before
        Loader::core('Config');
        
        if ($url !== NULL)
        {
            $baseURL = Config::get('baseURL');
            if ($baseURL)
            {
                return rtrim(Config::get('baseURL'), '/').'/'.ltrim($url, '/');
            }
            else
            {
                return ltrim($url);
            }
        }
        else
        {
            return Config::get('baseURL');
        }
    }
}

if ( ! function_exists('getRoute'))
{
    /**
     * 
     * @param string $index
     * @return string|null
     */
    function getRoute($index)
    {
        $route = Config::get($index, 'route');
        
        if (isset($route['route']))
        {
            return $route['route'];
        }
        
        return NULL;
    }
}

if ( ! function_exists('filterText'))
{
    /**
     * 
     * @param string $text
     * @param type $doHtmlSc Default is TRUE
     * @param type $doNl2Br Default is FALSE
     * @param type $ucWords Default is FALSE
     * @return string|null
     */
    function filterText($text = NULL, $doHtmlSc = TRUE, $doNl2Br = FALSE, $ucWords = FALSE)
    {
        if ( ! $text)
        {
            return NULL;
        }

        $text = stripslashes($text);

        $text = trim(strval($text));

        if ($doHtmlSc === TRUE)
        {
            $text = str_replace(array('&quot;', '&amp;', '&#039;', '&nbsp;'), array('"', '&', "'", ' '), $text);
            $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        }

        if ($doNl2Br === TRUE)
        {
            $text = str_replace(array("\r\n", "\r", "\n"), "<br />", $text);
        }

        if ($ucWords === TRUE)
        {
            $text = ucwords($text);
        }

        return $text;
    }
}

if ( ! function_exists('getCountry'))
{
    /**
     * 
     * @param string $country Default is NULL
     * @return string|null
     */
    function getCountry($country = NULL)
    {
        if ($country)
        {
            $list = array(
                'us' => 'United States',
                'ca' => 'Canada',
                'uk' => 'United Kingdom'
            );

            if (array_key_exists($country, $list))
            {
                return $list[$country];
            }
        }

        return NULL;
    }
}

if ( ! function_exists('substrText'))
{
    /**
     * 
     * @param string $text
     * @param int $limit
     * @param bool $threeDot
     * @return string
     */
    function substrText($text, $limit, $threeDot = FALSE)
    {
        if ( strlen($text) >= $limit )
        {
            return mb_substr($text, 0, $limit).($threeDot === TRUE ? '...' : '');
        }

        return $text;
    }
}

if ( ! function_exists('getType'))
{
    /**
     * 
     * @param string $type Default is NULL
     * @return string|null
     */
    function getType($type = NULL)
    {
        if ($type)
        {
            $list = array(
                'car' => 'Cars',
                'boat' => 'Boats and Yachts',
                'moto' => 'Bikes',
                'atv' => 'ATVs',
                'rv' => 'RVs',
                'trailer' => 'Trailers'
            );

            if (array_key_exists($type, $list))
            {
                return $list[$type];
            }
        }

        return NULL;
    }
}

if ( ! function_exists('showVal'))
{
    /**
     * 
     * @param string $value
     * @return strıng
     */
    function showVal($value = NULL)
    {
        if ($value)
        {
            return $value;
        }
        else
        {
            return '-';
        }
    }
}

if ( ! function_exists('formatNumber'))
{
    /**
     * 
     * @param int $number Default is NULL
     * @return string|null
     */
    function formatNumber($number = NULL)
    {
        if ($number !== NULL)
        {
            return number_format($number, 0, ',', '.');
        }

        return NULL;
    }
}

if ( ! function_exists('showDate'))
{
    /**
     * 
     * @param int $time Default is NULL
     * @return string
     */
    function showDate($time = NULL)
    {
        if ( ! $time)
        {
            $str = '-';
        }
        else if ($time > time()-60)
        {
            $time = time()-$time;
            $str = $time.' second'.(( $time > 1 ) ? 's' : '').' ago';
        }
        else if ($time > time()-3600)
        {
            $time = round((time()-$time)/60);
            $str = $time.' minute'.(( $time > 1 ) ? 's' : '').' ago';
        }
        else if ($time > time()-86400)
        {
            $time = round((time()-$time)/60/60);
            $str = $time.' hour'.(( $time > 1 ) ? 's' : '').' ago';
        }
        else if ($time > time()-604800)
        {
            $time = round((time()-$time)/60/60/24);
            $str = $time.' day'.(( $time > 1 ) ? 's' : '').' ago';
        }
        else if ($time > time()-2592000)
        {
            $time = round((time()-$time)/60/60/24/7);
            $str = $time.' week'.(( $time > 1 ) ? 's' : '').' ago';
        }
        else if ($time > time()-31104000)
        {
            $time = round((time()-$time)/60/60/24/30);
            $str = $time.' month'.(( $time > 1 ) ? 's' : '').' ago';
        }
        else if ($time < time()-31104000)
        {
            $time = round((time()-$time)/60/60/24/30/12);
            $str = $time.' year'.(( $time > 1 ) ? 's' : '').' ago';
        }
        else
        {
            $str = date('m-d-Y', $time);
        }

        return $str;
    }
}

if ( ! function_exists('showPrice'))
{
    /**
     * 
     * @param int $price Default is NULL
     * @param string $currency Default is FALSE
     * @return string|null
     */
    function showPrice($price = NULL, $currency = FALSE)
    {
        if ( $currency == 'CAD' )
        {
            return number_format($price, 0, ',', '.').' CAD';
        }
        else if ( $currency == 'EUR' )
        {
            return '$'.number_format($price, 0, ',', ',');
        }
        else if ( $currency == 'GBP' )
        {
            return '£'.number_format($price, 0, ',', ',');
        }
        else if ( $currency == 'USD' )
        {
            return '$'.number_format($price, 0, ',', ',');
        }
        else
        {
            return NULL;
        }
    }
}

if ( ! function_exists('showCondition'))
{
    /**
     * 
     * @param int $value
     * @return strıng
     */
    function showCondition($value)
    {
        if ($value == '1')
        {
            return 'New';
        }
        else if ($value == '2')
        {
            return 'Used';
        }
        else
        {
            return '-';
        }
    }
}

if ( ! function_exists('selectedVal'))
{
    /**
     * 
     * @param string $field
     * @param string $value Default is NULL
     * @return string
     */
    function selectedVal($field, $value = NULL)
    {
        if ($field === $value)
        {
            return ' selected="selected"';
        }
        else
        {
            return '';
        }
    }
}

if ( ! function_exists('redirect'))
{
    /**
     * 
     * @param string $url
     * @param int $code Default is 302
     */
    function redirect($url, $code = 302)
    {
        header("Location: ".$url, TRUE, $code);
        
        exit;
    }
}