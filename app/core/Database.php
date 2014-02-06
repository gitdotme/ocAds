<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Database Class
 */
class DB
{
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_dbHost;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_dbUser;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_dbPass;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_dbName;
    
    /**
     *
     * @access private
     * @static
     * @var object
     */
    private static $_db;
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_select = '';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_from = '';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_where = '';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_order = '';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_limit = '';
    
    /**
     *
     * @access private
     * @static
     * @var string
     */
    private static $_query;
    
    /**
     *
     * @access private
     * @static
     * @var mixed
     */
    private static $_result;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_numRows = 0;
    
    /**
     *
     * @access private
     * @static
     * @var int
     */
    private static $_numQueries = 0;
    
    /**
     *
     * @access private
     * @static
     * @var int Default is NULL
     */
    private static $_insertID = NULL;
    
    /**
     *
     * @access private
     * @static
     * @var mixed
     */
    private static $_errors;
    
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        // load database config
        require APP_DIR.'/config/database.php';
        
        if (isset($database['host']))
        {
            self::$_dbHost = $database['host'];
        }
        
        if (isset($database['user']))
        {
            self::$_dbUser = $database['user'];
        }
        
        if (isset($database['pass']))
        {
            self::$_dbPass = $database['pass'];
        }
        
        if (isset($database['name']))
        {
            self::$_dbName = $database['name'];
        }
    }
    
    /**
     * 
     * @static
     * @param string $query
     * @param array $data
     * @param bool $escape
     * @return void
     */
    public static function query($query, $data = array(), $escape = TRUE)
    {
        if ( ! self::$_db)
        {
            self::_connect();
        }
        
        if ( ! empty($data))
        {
            $query = str_replace("?", "'?'", $query);
            
            if ($escape)
            {
                $data = array_map(array(self, '_escape'), $data);
            }
            
            $query = preg_replace("/[?]/e", 'array_shift($data)', $query);
        }
        
        self::$_query = $query;
        self::$_result = self::$_db->query(self::$_query);
        self::$_numRows = self::$_result->num_rows;
        self::$_numQueries++;
    }
    
    /**
     * 
     * @static
     * @param string $column
     * @return void
     */
    public static function select($column)
    {
        $parse = preg_split("/[,]/", $column);
        if ($parse)
        {
            foreach ($parse as $val)
            {
                $first = self::$_select ? FALSE : TRUE;
                
                self::$_select .= ($first ? '' : ', ')."`".trim($val)."`";
            }
        }
    }
    
    /**
     * 
     * @static
     * @param string $table
     * @return void
     */
    public static function from($table)
    {
        $parse = preg_split("/[,]/", $table);
        if ($parse)
        {
            foreach ($parse as $val)
            {
                $first = self::$_from ? FALSE : TRUE;
                
                self::$_from .= ($first ? '' : ', ')."`".trim($val)."`";
            }
        }
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function where($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '=', 'AND', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereLess($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '<', 'AND', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereGreater($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '>', 'AND', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereLessEqual($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '<=', 'AND', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereGreaterEqual($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '>=', 'AND', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereNotEqual($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '!=', 'AND', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereOR($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '=', 'OR', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereORLess($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '<', 'OR', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereORGreater($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '>', 'OR', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereORLessEqual($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '<=', 'OR', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereORGreaterEqual($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '>=', 'OR', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function whereORNotEqual($key, $value = NULL, $escape = TRUE)
    {
        self::_makeWhere($key, $value, '!=', 'OR', $escape);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @return void
     */
    public static function whereIsNULL($key)
    {
        self::_makeWhere($key, NULL, '', 'AND', TRUE, TRUE);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @return void
     */
    public static function whereIsNotNULL($key)
    {
        self::_makeWhere($key, NULL, '', 'AND', TRUE, FALSE, TRUE);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @return void
     */
    public static function whereORIsNULL($key)
    {
        self::_makeWhere($key, NULL, '', 'OR', TRUE, TRUE);
    }
    
    /**
     * 
     * @static
     * @param string $key
     * @return void
     */
    public static function whereORIsNotNULL($key)
    {
        self::_makeWhere($key, NULL, '', 'OR', TRUE, FALSE, TRUE);
    }
    
    /**
     * 
     * @access private
     * @static
     * @param mixed $key String or Array
     * @param string $value
     * @param string $logic_op
     * @param string $cond_op
     * @param bool $escape
     * @param bool $null
     * @param bool $not_null
     */
    private static function _makeWhere($key, $value, $logic_op, $cond_op, $escape, $null = FALSE, $not_null = FALSE)
    {
        if ( ! is_array($key))
        {
            $key = array($key => $value);
        }
        
        if ($key)
        {
            foreach ($key as $column => $val)
            {
                $first = self::$_where ? FALSE : TRUE;
                
                if ($null === TRUE)
                {
                    self::$_where .= ($first ? '' : ' '.$cond_op.' ')."`".$column."` IS NULL";
                }
                else if ($not_null === TRUE)
                {
                    self::$_where .= ($first ? '' : ' '.$cond_op.' ')."`".$column."` IS NOT NULL";
                }
                else
                {
                    if ($val)
                    {
                        self::$_where .= ($first ? '' : ' '.$cond_op.' ')."`".$column."` ".$logic_op." '".($escape ? self::_escape($val) : $val)."'";
                    }
                }
            }
        }
    }
    
    /**
     * 
     * @static
     * @param mixed $key String or Array
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function like($key, $value = NULL, $escape = TRUE)
    {
        self::_makeLike($key, $value, FALSE, 'AND', $escape);
    }
    
    /**
     * 
     * @static
     * @param mixed $key String or Array
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function notLike($key, $value = NULL, $escape = TRUE)
    {
        self::_makeLike($key, $value, TRUE, 'AND', $escape);
    }
    
    /**
     * 
     * @static
     * @param mixed $key String or Array
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function likeOR($key, $value = NULL, $escape = TRUE)
    {
        self::_makeLike($key, $value, FALSE, 'OR', $escape);
    }
    
    /**
     * 
     * @static
     * @param mixed $key String or Array
     * @param string $value Default is NULL
     * @param bool $escape
     * @return void
     */
    public static function notLikeOR($key, $value = NULL, $escape = TRUE)
    {
        self::_makeLike($key, $value, TRUE, 'OR', $escape);
    }
    
    /**
     * 
     * @access private
     * @static
     * @param mixed $key String or Array
     * @param string $value Default is NULL
     * @param bool $not_like
     * @param string $cond_op
     * @param bool $escape
     * @return void
     */
    private static function _makeLike($key, $value, $not_like, $cond_op, $escape)
    {
        if ( ! is_array($key))
        {
            $key = array($key => $value);
        }
        
        if ($key)
        {
            foreach ($key as $key => $val)
            {
                if ($val)
                {
                    $first = self::$_where ? FALSE : TRUE;
                    
                    $val = str_replace(' ', '%', $val);
                    
                    self::$_where .= ($first ? '' : ' '.$cond_op.' ')."`".$key."` ".($not_like ? ' NOT' : '')."LIKE '%".($escape ? self::_escape($val) : $val)."%'";
                }
            }
        }
    }
    
    /**
     * 
     * @static
     * @param mixed $key String or Array
     * @param string $value Default is NULL
     * @param string $order
     * @return void
     */
    public static function orderBy($key, $order = 'asc')
    {
        if ( ! is_array($key))
        {
            $key = array($key => $order);
        }
        
        if ($key)
        {
            foreach ($key as $key => $val)
            {
                if ($val)
                {
                    $first = self::$_order ? FALSE : TRUE;
                    
                    if (strtolower($order) == 'rand')
                    {
                        self::$_order .= ($first ? '' : ', ').strtoupper($order).'()';
                    }
                    else
                    {
                        self::$_order .= ($first ? '' : ', ')."`".$key."` ".strtoupper($order);
                    }
                }
            }
        }
    }
    
    /**
     * 
     * @param int $limit
     * @param int $offset Default is NULL
     * @return void
     */
    public static function limit($limit, $offset = NULL)
    {
        self::$_limit = ($offset !== NULL ? $offset.',' : '').$limit;
    }
    
    /**
     * 
     * @static
     * @return void
     */
    public static function run()
    {
        self::$_query = '';
        
        if (self::$_select)
        {
            self::$_query .= 'SELECT '.self::$_select;
        }
        else
        {
            self::$_query .= 'SELECT *';
        }
        
        if (self::$_from)
        {
            self::$_query .= ' FROM '.self::$_from;
        }
        
        if (self::$_where)
        {
            self::$_query .= ' WHERE ('.self::$_where.')';
        }
        
        if (self::$_order)
        {
            self::$_query .= ' ORDER BY '.self::$_order;
        }
        
        if (self::$_limit)
        {
            self::$_query .= ' LIMIT '.self::$_limit;
        }
        
        self::$_query .= ';';
        
        if ( ! self::$_db)
        {
            self::_connect();
        }
        
        self::$_result = self::$_db->query(self::$_query);
        self::$_numRows = self::$_result->num_rows;
        self::$_numQueries++;
        
        self::_flush();
    }

    /**
     * 
     * @static
     * @param string $fetch
     * @param int $x
     * @return mixed
     */
    public static function getVar($fetch = 'object', $x = 0)
    {
        $result = self::_fetchResult($fetch);
        
        if ($result)
        {
            $values = array_values(get_object_vars($result));
        }
        
        self::_free();
        
        return (isset($values[$x]) AND $values[$x] !== '')
            ? $values[$x]
            : NULL;
    }
    
    /**
     * 
     * @static
     * @param string $fetch
     * @return mixed
     */
    public static function getRow($fetch = 'object')
    {
        $result = self::_fetchResult($fetch);
        
        if ($result)
        {
            return $result;
        }
        
        self::_free();
        
        return NULL;
    }
    
    /**
     * 
     * @static
     * @param string $fetch
     * @return array
     */
    public static function getResults($fetch = 'object')
    {
        $result = array();
        $num = 0;
        
        while ($row = self::_fetchResult($fetch))
        {
            $result[$num] = $row;
            $num++;
        }
        
        self::_free();
        
        return $result;
    }
    
    /**
     * 
     * @access private
     * @static
     * @param string $type
     * @return mixed
     */
    private static function _fetchResult($type)
    {
        if ( ! self::$_result)
        {
            return NULL;
        }
        
        if ($type == 'object')
        {
            $fetch = self::$_result->fetch_object();
        }
        else if ($type == 'array')
        {
            $fetch = self::$_result->fetch_array();
        }
        else if ($type == 'assoc')
        {
            $fetch = self::$_result->fetch_assoc();
        }
        else if ($type == 'row')
        {
            $fetch = self::$_result->fetch_row();
        }
        
        return $fetch;
    }
    
    /**
     * 
     * @static
     * @param string $table
     * @param array $value
     * @param array $cond
     * @param bool $escape
     * @return void
     */
    public static function update($table, $value, $cond, $limit = NULL, $escape = TRUE)
    {
        self::$_query = 'UPDATE `'.$table.'`';
        
        if ($value)
        {
            $set = '';
            
            foreach ($value as $key => $val)
            {
                $first = $update ? FALSE : TRUE;
                
                if ($val !== NULL)
                {
                    $set .= ($first ? '' : ', ')."`".$key."` = '".($escape ? self::_escape($val) : $val)."'";
                }
                else
                {
                    $set .= ($first ? '' : ', ')."`".$key."` = NULL";
                }
            }
            
            self::$_query .= ' SET '.$set;
        }
        
        if ($cond)
        {
            $where = '';
            
            foreach ($cond as $key => $val)
            {
                if ($val)
                {
                    $first = $where ? FALSE : TRUE;
                    
                    $where .= ($first ? '' : ' AND ')."`".$key."` = '".($escape ? self::_escape($val) : $val)."'";
                }
            }
            
            self::$_query .= ' WHERE ('.$where.')';
        }
        
        if ($limit !== NULL)
        {
            self::$_query .= ' LIMIT '.$limit;
        }
        
        self::$_query .= ';';
        
        if ( ! self::$_db)
        {
            self::_connect();
        }
        
        self::$_result = self::$_db->query(self::$_query);
        self::$_numQueries++;
    }
    
    /**
     * 
     * @static
     * @param string $table
     * @param array $value
     * @param bool $escape
     * @return void
     */
    public static function insert($table, $value, $escape = TRUE)
    {
        self::$_query = 'INSERT INTO `'.$table.'`';
        
        if ($value)
        {
            $columns = '';
            
            foreach ($value as $key => $val)
            {
                $first = $columns ? FALSE : TRUE;
                
                $columns .= ($first ? '' : ', ')."`".$key."`";
            }
            
            self::$_query .= ' ('.$columns.') ';
            
            $values = '';
            
            foreach ($value as $val)
            {
                $first = $values ? FALSE : TRUE;
                
                if ($val !== NULL)
                {
                    $values .= ($first ? '' : ', ')."'".($escape ? self::_escape($val) : $val)."'";
                }
                else
                {
                    $values .= ($first ? '' : ', ')."NULL";
                }
            }
            
            self::$_query .= ' VALUES ('.$values.');';
        }
        
        if ( ! self::$_db)
        {
            self::_connect();
        }
        
        self::$_result = self::$_db->query(self::$_query);
        self::$_numQueries++;
        
        if (self::$_db->insert_id)
        {
            self::$_insertID = self::$_db->insert_id;
        }
    }
    
    /**
     * 
     * @static
     * @return int
     */
    public static function numRows()
    {
        return self::$_numRows;
    }
    
    /**
     * 
     * @static
     * @return int
     */
    public static function numQueries()
    {
        return self::$_numQueries;
    }
    
    /**
     * 
     * @static
     * @return int
     */
    public static function insertID()
    {
        return self::$_insertID;
    }
    
    /**
     * 
     * @static
     * @return int
     */
    public static function affectedRows()
    {
        return self::$_db->affected_rows;
    }
    
    /**
     * 
     * @access private
     * @static
     * @param mixed $str String or Integer
     * @return mixed String or Integer
     */
    private static function _escape($str = NULL)
    {
        if ( ! self::$_db)
        {
            self::_connect();
        }
        
        if ($str !== NULL)
        {
            return self::$_db->real_escape_string($str);
        }
        else
        {
            return NULL;
        }
    }
    
    /**
     * 
     * @access private
     * @static
     * @return void
     */
    private static function _connect()
    {
        // return false if db has already connected
        if (self::$_db)
        {
            return;
        }
        
        try
        {
            self::$_db = new mysqli(self::$_dbHost, self::$_dbUser, self::$_dbPass, self::$_dbName);
            
            self::$_db->set_charset('utf8');
            
            if (self::$_db->connect_errno)
            {
                throw new Exception('Cannot connect to DB: '.self::$_db->connect_error);
            }
        }
        catch (Exception $e)
        {
            // trigger caught error
            logMessage('error', $e->getMessage(), TRUE);
            
            // show error page
            showError('Cannot connect to database.', 'Database Error', 500);
        }
    }
    
    /**
     * 
     * @access private
     * @static
     * @return void
     */
    private static function _free()
    {
        if (self::$_result)
        {
            self::$_result->free();
        }
    }
    
    /**
     * 
     * @access private
     * @static
     * @return void
     */
    private static function _flush()
    {
        self::$_select = '';
        self::$_from = '';
        self::$_where = '';
        self::$_order = '';
        self::$_limit = '';
    }
    
    /**
     * 
     * @static
     * @return string
     */
    public static function error()
    {
        return self::$_db->error;
    }
    
    /**
     * 
     * @access private
     * @static
     * @return void
     */
    public static function debug()
    {
        echo '<pre>';
        echo 'Query: '.(self::$_query ? self::$_query : 'NULL').'<br>';
        echo 'Num Rows: '.self::$_numRows.'<br>';
        echo 'Num Queries: '.self::$_numQueries.'<br>';
        echo 'Insert ID: '.(self::$_insertID ? self::$_insertID : 'NULL').'<br>';
        echo 'Affected Rows: '.self::$_db->affected_rows.'<br>';
        echo 'Error: '.(self::$_db->error ? self::$_db->error : 'NULL').'<br>';
        echo '</pre>';
    }
    
    /**
     * 
     * @static
     * @return void
     */
    public static function close()
    {
        if (self::$_db)
        {
            self::$_db->close();
        }
    }
}