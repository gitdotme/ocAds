<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Form Library
 */
class Form
{
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_vars = array();
    
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_rules = array();
    
    /**
     *
     * @access private
     * @static
     * @var array
     */
    private static $_errors = array();
    
    /**
     * 
     * @access private
     * @return void
     */
    private function __construct()
    {
        // nothing to do
    }
    
    /**
     * 
     * @static
     * @param string $name
     * @param string $rule
     * @return void
     */
    public static function rule($name, $rule)
    {
        self::$_rules[$name] = $rule;
    }
    
    /**
     * 
     * @static
     * @return boolean
     */
    public static function run()
    {
        self::$_errors = array();
        
        if ( ! empty(self::$_rules))
        {
            foreach (self::$_rules as $key => $value)
            {
                self::_registerVar($key);
                
                $parse = self::_parseRule($value);
                
                $post_item = Input::post($key)
                        ? Input::post($key)
                        : NULL;
                
                if (isset($parse['required']))
                {
                    if ( ! $post_item)
                    {
                        self::$_errors[] = sprintf('%s is required.', ucfirst($key));
                    }
                }

                if ( ! $post_item)
                {
                    continue;
                }

                if (isset($parse['trim']))
                {
                    $post_item = trim($post_item);
                }
                
                if (isset($parse['integer']))
                {
                    if ( ! is_int($post_item))
                    {
                        self::$_errors[] = sprintf('%s must contain an integer.', ucfirst($key));
                    }
                }

                if (isset($parse['numeric']))
                {
                    if ( ! is_numeric($post_item))
                    {
                        self::$_errors[] = sprintf('%s must contain a numeric.', ucfirst($key));
                    }
                }
                
                if (isset($parse['alpha']))
                {
                    if ( ! preg_match("/^([a-z])+$/i", $post_item))
                    {
                        self::$_errors[] = sprintf('%s may only contain alphabetical characters.', ucfirst($key));
                    }
                }

                if (isset($parse['matches']))
                {
                    if ($post_item !== Input::post($parse['matches']))
                    {
                        self::$_errors[] = sprintf('%s does not match the %s', ucfirst($key), ucfirst(Input::post($parse['matches'])));
                    }
                }

                if (isset($parse['minLength']))
                {
                    if (strlen($post_item) < $parse['minLength'])
                    {
                        self::$_errors[] = sprintf('%s must be at least %s characters in length.', ucfirst($key), $parse['minLength']);
                    }
                }

                if (isset($parse['maxLength']))
                {
                    if (strlen($post_item) > $parse['maxLength'])
                    {
                        self::$_errors[] = sprintf('%s can not exceed %s characters in length.', ucfirst($key), $parse['maxLength']);
                    }
                }
                
                if (isset($parse['validEmail']))
                {
                    if ( ! filter_var($post_item, FILTER_VALIDATE_EMAIL))
                    {
                        self::$_errors[] = sprintf('%s must contain a valid email address.', ucfirst($key));
                    }
                }
                
                if (isset($parse['verifyCaptcha']))
                {
                    if ($post_item !== Session::get('captcha'))
                    {
                        self::$_errors[] = sprintf('%s is wrong.', ucfirst($key));
                    }
                    else
                    {
                        Session::set('verifyCaptcha', TRUE);
                    }
                }
            }
        }
        
        if (self::$_errors)
        {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * 
     * @access private
     * @static
     * @param string $rule
     * @return array|null
     */
    private static function _parseRule($rule)
    {
        $rules = preg_split("/[|]/", $rule);
        
        if ($rules)
        {
            $set_rules = array();
            
            foreach ($rules as $var)
            {
                if (strpos($var, ':') !== FALSE)
                {
                    $split = preg_split("/[:]/", $var);
                    
                    $set_rules[$split[0]] = $split[1];
                }
                else
                {
                    $set_rules[$var] = TRUE;
                }
            }
            
            return $set_rules;
        }
        
        return NULL;
    }
    
    /**
     * 
     * @access private
     * @static
     * @param string $var
     * @return void
     */
    private static function _registerVar($var)
    {
        self::$_vars[] = $var;
    }
    
    /**
     * 
     * @static
     * @return void
     */
    public static function reset()
    {
        if (self::$_vars)
        {
            foreach (self::$_vars as $var)
            {
                Input::set('post', $var, NULL);
            }
        }
    }
    
    /**
     * 
     * @return string
     */
    public static function errors()
    {
        $str = '';
        
        if (self::$_errors)
        {
            foreach (self::$_errors as $error)
            {
                $str .= '<p>'.$error.'</p>';
            }
        }
        
        return $str;
    }
}