<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * XML Helper
 */
if ( ! function_exists('xmlDOM'))
{
    /**
     * 
     * @return object
     */
    function xmlDOM()
    {
        return new DOMDocument('1.0', 'UTF-8');
    }
}

if ( ! function_exists('xmlAddChild'))
{
    /**
     * 
     * @param string $parent
     * @param string $name
     * @param string $value Default is NULL
     * @param bool $cdata Default is FALSE
     * @return object
     */
    function xmlAddChild($parent, $name, $value = NULL, $cdata = FALSE)
    {
        if ($parent->ownerDocument != "")
        {
            $dom = $parent->ownerDocument;            
        }
        else
        {
            $dom = $parent;
        }
        
        $child = $dom->createElement($name);        
        $parent->appendChild($child);
        
        if ($value != NULL)
        {
            if ($cdata)
            {
                $child->appendChild($dom->createCdataSection($value));
            }
            else
            {
                $child->appendChild($dom->createTextNode($value));
            }
        }
        
        return $child;        
    }
}

if ( ! function_exists('xmlAddAttribute'))
{
    /**
     * 
     * @param object $node
     * @param string $name
     * @param string $value Default is NULL
     * @return object
     */
    function xmlAddAttribute($node, $name, $value = NULL)
    {
        $dom = $node->ownerDocument;            
        
        $attribute = $dom->createAttribute($name);
        $node->appendChild($attribute);
        
        if ($value != NULL)
        {
            $attribute_value = $dom->createTextNode($value);
            $attribute->appendChild($attribute_value);
        }
        
        return $node;
    }
}

if ( ! function_exists('xmlSetAttribute'))
{
    /**
     * 
     * @param object $node
     * @param string $name
     * @param string $value Default is NULL
     */
    function xmlSetAttribute($node, $name, $value = NULL)
    {          
        if ($value != NULL)
        {
            $node->setAttribute($name, $value);
        }
    }
}

if ( ! function_exists('xml_convert'))
{
    /**
     * 
     * @param string $str
     * @param bool $protectAll
     * @return string
     */
    function xmlConvert($str, $protectAll = FALSE)
    {
        $temp = '__TEMP__';
        
        $str = preg_replace("/&#(\d+);/", "$temp\\1;", $str);
        
        if ($protectAll === TRUE)
        {
            $str = preg_replace("/&(\w+);/",  "$temp\\1;", $str);
        }
        
        $str = str_replace(array("&","<",">","\"", "'", "-"),
                array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;", "&#45;"),
                $str);
        
        $str = preg_replace("/$temp(\d+);/","&#\\1;",$str);
        
        if ($protectAll === TRUE)
        {
            $str = preg_replace("/$temp(\w+);/","&\\1;", $str);
        }
        
        return $str;
    }
}

if ( ! function_exists('xmlPrint'))
{
    /**
     * 
     * @param object $dom
     * @param bool $returnDefault is FALSE
     * @return string
     */
    function xmlPrint($dom, $return = FALSE)
    {
        $dom->formatOutput = TRUE;
        $xml = $dom->saveXML();
        
        if ($return)
        {
            return $xml;
        }
        else
        {
            echo $xml;
        }
    }
}