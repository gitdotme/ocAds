<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Home Model
 */
class mHome extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 
     * @param string $type
     * @return object
     */
    public function getMakes($type)
    {
        DB::select('title');
        DB::from($type);
        DB::orderBy('title', 'asc');
        DB::run();
        
        return DB::getResults();
    }
    
    /**
     * 
     * @param string $order
     * @param int $limit
     * @return object|null
     */
    public function getTags($order, $limit = 10)
    {
        if ( ! Config::get('home'.ucfirst($order), 'tags'))
        {
            return NULL;
        }
        
        DB::select('tag');
        DB::from('tag');
        
        if ($order == 'latest')
        {
            DB::orderBy('id', 'desc');
        }
        else if ($order == 'random')
        {
            DB::orderBy('id', 'rand');
        }
        
        $config_limit = Config::get('home'.ucfirst($order).'Limit', 'tags');
        if ($config_limit)
        {
            $limit = $config_limit;
        }
        
        DB::limit($limit);
        DB::run();
        
        return DB::getResults();
    }
}