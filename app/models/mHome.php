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
     * @param int $limit Default is 10
     * @return object|null
     */
    public function getTags($order, $limit = 10)
    {
        if ( ! Config::get('home'.ucfirst($order), 'tags'))
        {
            return NULL;
        }

        if ($order == 'latest')
        {
            DB::select('tag');
            DB::from('tag');
            DB::orderBy('id', 'desc');
        }
        else if ($order == 'random')
        {
            $range = $this->_tagsRandomRange();
            
            DB::select('tag');
            DB::from('tag');
            DB::whereGreaterEqual('id', $range['start']);
            DB::whereLessEqual('id', $range['end']);
            DB::orderBy('id', 'rand');
        }

        $configLimit = Config::get('home'.ucfirst($order).'Limit', 'tags');
        if ($configLimit)
        {
            $limit = $configLimit;
        }

        DB::limit($limit);
        DB::run();

        return DB::getResults();
    }

    /**
     *
     * @return array
     */
    private function _tagsRandomRange()
    {
        DB::select('id');
        DB::from('tag');
        DB::run();

        $tagsCount = DB::numRows();
        
        $rangeSize = Config::get('tagsRangeSize', 'tags');

        if ($rangeSize >= $tagsCount)
        {
            return array(
                'start' => 1,
                'end' => $tagsCount
            );
        }

        $rangeStart = rand(1, $tagsCount);

        if (($rangeStart + $rangeSize) > $tagsCount)
        {
            $rangeStart -= ($rangeStart + $rangeSize) - $tagsCount;
        }

        $rangeEnd = $rangeStart+$rangeSize;

        return array(
            'start' => $rangeStart,
            'end' => $rangeEnd
        );
    }
}