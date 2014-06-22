<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Home Search
 */
class mSearch extends Model
{
    public function __construct()
    {
        parent::__construct();
        
        Loader::library('API', TRUE);
        Loader::library('Curl');
    }
    
    /**
     * 
     * @param array $getData
     * @return array
     */
    public function fixDashes($getData)
    {
        $getData['query'] = str_replace('-', ' ', $getData['query']);
        $getData['state'] = str_replace('-', ' ', $getData['state']);
        $getData['city'] = str_replace('-', ' ', $getData['city']);
        $getData['make'] = str_replace('-', ' ', $getData['make']);
        $getData['model'] = str_replace('-', ' ', $getData['model']);
        
        return $getData;
    }
    
    /**
     * 
     * @param array $getData
     * @return array
     */
    public function fixLower($getData)
    {
        $getData['state'] = ucwords($getData['state']);
        $getData['city'] = ucwords($getData['city']);
        $getData['make'] = ucwords($getData['make']);
        $getData['model'] = ucwords($getData['model']);
        
        return $getData;
    }
    
    /**
     * 
     * @param array $getData
     * @param int $resultsLimit Default is NULL
     * @return array
     */
    public function apiResults($getData)
    {
        API::setParams($getData);
        
        $paginaLimit = Config::get('searchPaginaLimit', 'limit');
        $maxResults = $paginaLimit * API::getResultsLimit();
        
        $items = API::search();
        $apiTotal = API::getTotal();
        $total = ($apiTotal > $maxResults) ? $maxResults : $apiTotal;
        
        return array(
            'items' => $items,
            'total' => $total
        );
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
    
    /**
     * 
     * @param string $query Default NULL
     * @param int $total
     * @return void
     */
    public function saveTags($query = NULL, $total)
    {
        if ($query == NULL OR $total < 1)
        {
            return;
        }
        
        if ( ! Config::get('save', 'tags'))
        {
            return;
        }
        
        if (strlen(seoLinks($query, TRUE)) < Config::get('minCharLimit', 'tags'))
        {
            return;
        }
        
        if ($total < Config::get('minResultsLimit', 'tags'))
        {
            return;
        }
        
        $query = str_replace('-', ' ', seoLinks($query, TRUE));
        
        DB::select('tag');
        DB::from('tag');
        DB::where(array('tag' => $query));
        DB::limit(1);
        DB::run();
        
        $getTag = DB::getVar();
        if ($getTag)
        {
            return;
        }
        
        DB::insert('tag', array('tag' => $query));
    }
    
    /**
     * 
     * @param string $type
     * @param array $getData
     * @param int $total Default is NULL
     * @return array
     */
    public function setSeo($type, $getData, $total = NULL)
    {
        switch ($type)
        {
            case 'search':
                return array(
                    'query' => ucwords(filterText($getData['query'])),
                    'type' => getType($getData['type']),
                    'country' => getCountry($getData['country']),
                    'make' => ucwords(filterText($getData['make'])),
                    'model' => ucwords(filterText($getData['model'])),
                    'condition' => showCondition($getData['condition']),
                    'color' => ucwords(filterText($getData['color'])),
                    'state' => ucwords(filterText($getData['state'])),
                    'city' => ucwords(filterText($getData['city'])),
                    'location' => ucwords(filterText($getData['location'])),
                    'page' => filterText($getData['page']),
                    'total' => ($total > 0) ? formatNumber($total) : 0
                );
                break;
            
            case 'tags':
                return array(
                    'tag' => ucwords(filterText($getData['query'])),
                    'type' => getType($getData['type']),
                    'country' => getCountry($getData['country']),
                    'page' => filterText($getData['page']),
                    'total' => ($total > 0) ? formatNumber($total) : 0
                );
                break;
            
            default:
                return NULL;
                break;
        }
    }
    
    /**
     * 
     * @param array $data
     * @param array $getData
     * @return string
     */
    public function getRSS($data = array(), $getData = array())
    {
        Loader::helper('XML');
 
        $dom = xmlDOM();
        
        $rss = xmlAddChild($dom, 'rss');
        xmlSetAttribute($rss, 'version', '2.0');
        xmlSetAttribute($rss, 'xmlns:dc', 'http://purl.org/dc/elements/1.1/');
        xmlSetAttribute($rss, 'xmlns:sy', 'http://purl.org/rss/1.0/modules/syndication/');
        xmlSetAttribute($rss, 'xmlns:admin', 'http://webns.net/mvcb/');
        xmlSetAttribute($rss, 'xmlns:rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
        xmlSetAttribute($rss, 'xmlns:content', 'http://purl.org/rss/1.0/modules/content/');
        xmlSetAttribute($rss, 'xmlns:media', 'http://search.yahoo.com/mrss/');

        $channel = xmlAddChild($rss, 'channel');
        
        xmlAddChild($channel, 'title', Config::get('siteName', 'seo'));
        xmlAddChild($channel, 'link', baseURL());
        xmlAddChild($channel, 'description', Config::get('siteDesc', 'seo'));
        xmlAddChild($channel, 'dc:language', 'en-en');
        
        $atom = xmlAddChild($channel, 'atom10:link');
        xmlSetAttribute($atom, 'xmlns:atom10', 'http://www.w3.org/2005/Atom');
        xmlSetAttribute($atom, 'href', searchLink($getData, TRUE, NULL, TRUE));
        xmlSetAttribute($atom, 'rel', 'self');
        xmlSetAttribute($atom, 'type', 'application/rss+xml');
        
        if (isset($data['items']))
        {
            foreach ($data['items'] as $entry)
            {
                $item = xmlAddChild($channel, 'item');
                
                xmlAddChild($item, 'title', xmlConvert(filterText($entry->title)), TRUE);
                
                $itemLink = itemLink($entry->hash);
                
                xmlAddChild($item, 'link', $itemLink);
                xmlAddChild($item, 'guid', $itemLink);
                xmlAddChild($item, 'description', filterText($entry->content, TRUE, TRUE), TRUE);
                xmlAddChild($item, 'pubDate', date('D, d M Y H:i:s O', $entry->time));
                
                if ($entry->picture)
                {
                    $media = xmlAddChild($item, 'media:thumbnail');
                    xmlSetAttribute($media, 'url', $entry->picture);
                    xmlSetAttribute($media, 'width', '120');
                    xmlSetAttribute($media, 'height', '100');
                }
            }
        }
        
        return xmlPrint($dom, TRUE);
    }
}