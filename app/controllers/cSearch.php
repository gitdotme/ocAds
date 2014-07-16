<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Search Controller
 */
class cSearch extends Controller
{
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->loadModel('search');
        
        Loader::library('Pagination');
        
        Layout::css('assets/css/common.css');
        Layout::css('assets/css/jquery.slider.min.css');
        Layout::js('assets/js/jquery.min.js');
        Layout::js('assets/js/jquery.placeholder.js');
        Layout::js('assets/js/jquery.slider.min.js');
        Layout::js('assets/js/jquery.lazyload.min.js');
        Layout::js('assets/js/common.js');
    }
    
    /**
     * 
     * @param string $tag Default is NULL
     * @param int $page Default is NULL
     * @return void
     */
    public function index($tag = NULL, $page = NULL)
    {
        $getData = array(
            'query' => $tag ? $tag : Input::get('query'),
            'type' => Input::get('type'),
            'country' => Input::get('country'),
            'make' => Input::get('make'),
            'model' => Input::get('model'),
            'year_min' => Input::get('year_min'),
            'year_max' => Input::get('year_max'),
            'price_min' => Input::get('price_min'),
            'price_max' => Input::get('price_max'),
            'currency' => Input::get('currency'),
            'condition' => Input::get('condition'),
            'color' => Input::get('color'),
            'mileage_min' => Input::get('mileage_min'),
            'mileage_max' => Input::get('mileage_max'),
            'vehicle' => Input::get('vehicle'),
            'vin' => Input::get('vin'),
            'state' => Input::get('state'),
            'city' => Input::get('city'),
            'location' => Input::get('location'),
            'order' => Input::get('order'),
            'page' => $page ? $page : Input::get('page')
        );
        
        $getData = $this->mSearch->fixDashes($getData);
        $getData = $this->mSearch->fixLower($getData);
        
        $data = $this->mSearch->apiResults($getData);
        
        $data['params'] = $getData;
        
        $data['yearMin'] = $getData['year_min'] ? $getData['year_min'] : 1980;
        $data['yearMax'] = $getData['year_max'] ? $getData['year_max'] : (int) date('Y');
        $data['priceMin'] = $getData['price_min'] ? $getData['price_min'] : 0;
        $data['priceMax'] = $getData['price_max'] ? $getData['price_max'] : 50000;
        $data['mileageMin'] = $getData['mileage_min'] ? $getData['mileage_min'] : 0;
        $data['mileageMax'] = $getData['mileage_max'] ? $getData['mileage_max'] : 200000;
        
        $this->mSearch->saveTags($getData['query'], $data['total']);
        
        $data['latestTags'] = $this->mSearch->getTags('latest');
        $data['randomTags'] = $this->mSearch->getTags('random');
        
        if ($tag !== NULL)
        {
            Pagination::setQueryString(FALSE);
            Pagination::setURL(tagLink($getData['query']));
            
            $seoData = $this->mSearch->setSeo('tags', $getData, $data['total']);
            
            Layout::title(getSeo($seoData, 'tagsTitle'));
            Layout::desc(getSeo($seoData, 'tagsDesc'));
            Layout::heading(getSeo($seoData, 'tagsHeading'));
        }
        else
        {
            Pagination::setQueryString(TRUE);
            Pagination::setURL(searchLink($getData, FALSE));
            
            $seoData = $this->mSearch->setSeo('search', $getData, $data['total']);
            
            Layout::title(getSeo($seoData, 'searchTitle'));
            Layout::desc(getSeo($seoData, 'searchDesc'));
            Layout::heading(getSeo($seoData, 'searchHeading'));
        }
        
        Pagination::setTotal($data['total'], Config::get('searchResultsLimit', 'limit'), Config::get('searchPaginaLimit', 'limit'));
        Pagination::setCurrent($getData['page']);
        Pagination::setNumLinks(3);
        Pagination::run();
        $data['pagination'] = Pagination::getPagina();
        
        Layout::view('vSearch', $data);
    }
    
    /**
     * 
     * @return void
     */
    public function rss()
    {
        $getData = array(
            'query' => Input::get('query'),
            'type' => Input::get('type'),
            'country' => Input::get('country'),
            'make' => Input::get('make'),
            'model' => Input::get('model'),
            'year_min' => Input::get('year_min'),
            'year_max' => Input::get('year_max'),
            'price_min' => Input::get('price_min'),
            'price_max' => Input::get('price_max'),
            'currency' => Input::get('currency'),
            'condition' => Input::get('condition'),
            'color' => Input::get('color'),
            'mileage_min' => Input::get('mileage_min'),
            'mileage_max' => Input::get('mileage_max'),
            'vehicle' => Input::get('vehicle'),
            'vin' => Input::get('vin'),
            'state' => Input::get('state'),
            'city' => Input::get('city'),
            'location' => Input::get('location'),
            'order' => Input::get('order'),
            'page' => Input::get('page'),
            'search' => Input::get('search')
        );
        
        // get results
        $data = $this->mSearch->apiResults($getData);
        
        // set css and render template
        $xml = $this->mSearch->getRSS($data, $getData);
        
        header('Content-Type: application/xhtml+xml; charset=utf-8');
        
        echo $xml;
    }
}