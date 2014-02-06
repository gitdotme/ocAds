<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Pagination Library
 */
class Pagination
{
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_css = 'pagina';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_queryString = TRUE;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_uriSegment = 'page';
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_total;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_current;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_numLinks;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_url;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_pagina = '';
    
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        // nothing to do
    }
    
    /**
     * @static
     * @param bool $queryString
     * @return void
     */
    public static function setQueryString($queryString)
    {
        self::$_queryString = $queryString;
    }
    
    /**
     * @static
     * @param int $total
     * @return void
     */
    public static function setTotal($total, $resultsLimit, $paginaLimit)
    {
        $ceiled_total = ceil($total / $resultsLimit);
        
        self::$_total = ($ceiled_total > $paginaLimit) ? $paginaLimit : $ceiled_total;
    }
    
    /**
     * @static
     * @param int $current
     * @return void
     */
    public static function setCurrent($page)
    {
        self::$_current = ($page < 1) ? 1 : (($page > self::$_total) ? self::$_total : $page);
    }
    
    /**
     * @static
     * @param int $numLinks
     * @return void
     */
    public static function setNumLinks($numLinks)
    {
        self::$_numLinks = $numLinks;
    }
    
    /**
     * @static
     * @param int $url
     * @return void
     */
    public static function setURL($url)
    {
        self::$_url = $url;
    }
    
    /**
     * 
     * @return void
     */
    public static function run()
    {
        if (self::$_total > 1)
        {
            self::$_pagina .= '<div class="'.self::$_css.'">';
            
            if (strpos(self::$_url, '?') === FALSE)
            {
                $amp = '?';
            }
            else
            {
                $amp = '&amp;';
            }
            
            if (self::$_current > 1 )
            {
                if ((self::$_current - 1) == 1)
                {
                    self::$_pagina .= '<a href="'.self::$_url.'">&laquo; Previous</a>&nbsp;';
                }
                else
                {
                    self::$_pagina .= '<a href="'.self::$_url.(self::$_queryString ? $amp.self::$_uriSegment.'=' : '/') . (self::$_current - 1).'">&laquo; Previous</a>&nbsp;';
                }
            }
                
            if ( self::$_current > 6 )
            {
                self::$_pagina .= '<a href="'.self::$_url.'">1</a>&nbsp;&nbsp;&hellip;&nbsp;&nbsp;';
            }
            
            $begin = ((self::$_current - self::$_numLinks) < 1) ? 1 : (self::$_current - self::$_numLinks);
            $end = ((self::$_current + self::$_numLinks) < self::$_total) ? (self::$_current + self::$_numLinks) : self::$_total;
            
            for ($i = $begin; $i <= $end; $i++)
            {
                if ($i == self::$_current)
                {
                    self::$_pagina .= '<span class="active">'.$i.'</span>&nbsp;';
                }
                else
                {
                    if ($i == 1)
                    {
                        self::$_pagina .= '<a href="'.self::$_url.'">'.$i.'</a>&nbsp;';
                    }
                    else
                    {
                        self::$_pagina .= '<a href="'.self::$_url .(self::$_queryString ? $amp.self::$_uriSegment.'=' : '/') . $i.'">'.$i.'</a>&nbsp;';
                    }
                }
            }
            
            if (self::$_current < (self::$_total - 6))
            {
                self::$_pagina .= '&nbsp;&nbsp;&hellip;&nbsp;&nbsp;<a href="'.self::$_url .(self::$_queryString ? $amp.self::$_uriSegment.'=' : '/') . self::$_total.'">'.self::$_total.'</a>&nbsp;';
            }
            
            if (self::$_current < self::$_total)
            {
                self::$_pagina .= '<a href="'.self::$_url .(self::$_queryString ? $amp.self::$_uriSegment.'=' : '/') . (self::$_current + 1).'">Next &raquo;</a>&nbsp;';
            }
            
            self::$_pagina .= '</div>';
        }
    }
    
    /**
     * @static
     * @return string|null
     */
    public static function getPagina()
    {
        if (self::$_pagina)
        {
            return self::$_pagina;
        }
        
        return NULL;
    }
}