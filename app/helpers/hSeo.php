<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

if ( ! function_exists('makeKeywords'))
{
    /**
     * 
     * @param string $str
     * @return string
     */
    function makeKeywords($str)
    {
        $str = str_replace(array('-', '.', ',', '_', '/', '(', ')', '=', '&', '&amp;'), '', $str);
        $str = preg_replace('/([\s]+)/', ' ', $str);
        $str = str_replace(' ', ', ', $str);

        return $str;
    }
}

if ( ! function_exists('seoLinks'))
{
    /**
     * 
     * @param string $str
     * @param boolean $doLower
     * @return string
     */
    function seoLinks($str, $doLower = FALSE, $ucWords = FALSE)
    {
        $str = html_entity_decode($str);

        $str = str_replace(array('ç','ğ','ı','i','ö','ş','ü','Ç','Ğ','İ','Ö','Ş','Ü'),array('c','g','i','i','o','s','u','C','G','I','O','S','U'),$str);
        $str = str_replace(array('â','î','û','ô','ê','Â','Î','Û','Ô','Ê'), array('a','i','u','o','e','A','I','U','O','E'), $str);
        $str = str_replace(array('à','í','ì','ù','ó','ò','é','è','ë','À','Í','Ù','Ó','É'), array('a','i','i','u','o','o','e','e','e','A','I','U','O','E'), $str);

        if ($doLower === TRUE)
        {
            $str = strtolower($str);
        }
        
        if ($ucWords === TRUE)
        {
            $str = ucwords($str);
        }

        $str = preg_replace("/[^a-zA-Z0-9]/i", '-', $str);
        $str = preg_replace('/([-]+)/', '-', $str);

        $str = trim($str, '-');

        return $str;
    }
}

if ( ! function_exists('itemLink'))
{
    /**
    * 
    * @param string $make
    * @param string $model Default is NULL
    * @return string
    */
    function itemLink($hash)
    {
        return baseUrl(str_replace('{hash}', seoLinks($hash), Config::get('itemLink', 'seo')));
    }
}

if ( ! function_exists('makeParams'))
{
    /**
     * 
     * @param array $params
     * @param boolean $page Default is TRUE
     * @param array $extend Default is NULL
     * @return string|null
     */
    function makeParams($params, $page = TRUE, $extend = NULL)
    {
        if ($params)
        {
            if ($page === FALSE)
            {
                unset($params['page']);
            }

            $str = '';

            if ($extend)
            {
                foreach ($extend as $key => $val)
                {
                    if (isset($val) && $val != '')
                    {
                        $params[$key] = $val;
                    }
                }
            }

            foreach ($params as $key => $val)
            {
                if (isset($val) && $val != '')
                {
                    $str .= '&amp;'.filterText($key).'='.urlencode(filterText($val));
                }
            }

            return substr($str, 5);
        }
        
        return NULL;
    }
}

if ( ! function_exists('searchLink'))
{
    /**
     * 
     * @param array $params
     * @param boolean $page Default is TRUE
     * @param array $extend Extra params field. Default is NULL
     * @param boolean $rss Default is FALSE
     * @return string
     */
    function searchLink($params, $page = TRUE, $extend = NULL, $rss = FALSE)
    {
        if ($rss === FALSE)
        {
            $link = 'searchLink';
        }
        else
        {
            $link = 'rssLink';
        }

        $str = makeParams($params, $page, $extend);

        return baseURL(Config::get($link, 'seo').($str ? '?'.$str : ''));
    }
}

if ( ! function_exists('tagLink'))
{
    /**
    * 
    * @param string $str
    * @return string
    */
    function tagLink($str)
    {
        return baseUrl(str_replace('{tag}', seoLinks($str, TRUE), Config::get('tagLink', 'seo')));
    }
}

if ( ! function_exists('modelLink'))
{
    /**
    * 
    * @param string $make
    * @param string $model Default is NULL
    * @return string
    */
    function modelLink($make, $model = NULL)
    {
        return tagLink($make.' '.$model);
    }
}

if ( ! function_exists('getSeo'))
{
    /**
     * 
     * @param array $vars
     * @param string $item
     * @return string
     */
    function getSeo($vars, $item)
    {
        $str = Config::get($item, 'seo');
        
        preg_match_all('/\[([a-zA-Z0-9-\{\} ]+)\]/Uis', $str, $parts);
        if ($parts[1])
        {
            foreach ($parts[1] as $part)
            {
                preg_match_all('/{([a-zA-Z0-9- ]+)}/Uis', $part, $params);
                if ($params[1])
                {
                    $tmp_str = $str;
                    foreach ($params[1] as $param)
                    {
                        if ($vars[$param] !== FALSE && $vars[$param] !== "")
                        {
                            $str = str_replace('{'.$param.'}', $vars[$param], $str);
                        }
                        else
                        {
                            $str = str_replace('['.$part.']', '', $tmp_str);
                        }
                    }
                }
            }
        }

        $str = preg_replace('/([\s]+)/', ' ', $str);
        $str = str_replace(array('[', ']'), '', $str);
        $str = str_replace(' - - ', ' - ', $str);
        $str = trim($str, ' -,');

        return $str;

        /*preg_match_all('/\[([\w\W]+)\]/Uis', $str, $parts);
        if ($parts[1])
        {
            foreach ($parts[1] as $part)
            {
                preg_match_all('/{([\w\W\s]+)}/Uis', $part, $params);
                if ($params[1])
                {
                    $tmp_str = $str;
                    foreach ($params[1] as $param)
                    {
                        if (strpos($param, ':') !== FALSE)
                        {
                            $param_else = substr(strstr($param, ':'), 1);
                            $param = strstr($param, ':', TRUE);
                        }
                        
                        if ($vars[$param] !== FALSE AND $vars[$param] !== "")
                        {
                            $str = str_replace('{'.$param.'}', $vars[$param], $str);
                        }
                        else
                        {
                            if (isset($param_else))
                            {
                                $str = str_replace('{'.$param.':'.$param_else.'}', $param_else, $str);
                            }
                            else
                            {
                                $str = str_replace('['.$part.']', '', $tmp_str);
                            }
                        }
                    }
                }
            }
        }

        $str = preg_replace('/([\s]+)/', ' ', $str);
        $str = str_replace(array('[', ']'), '', $str);
        $str = str_replace(' - - ', ' - ', $str);
        $str = trim($str, ' -,');

        return $str;*/
    }
}