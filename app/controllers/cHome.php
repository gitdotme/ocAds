<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Home Controller
 */
class cHome extends Controller
{
    /**
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->loadModel('home');
        
        Layout::css('assets/css/common.css');
        Layout::js('assets/js/jquery.min.js');
        Layout::js('assets/js/jquery.placeholder.js');
        Layout::js('assets/js/common.js');
    }
    
    /**
     * 
     * @return void
     */
    public function index()
    {
        $data = array();
        
        $type = Config::get('searchType', 'search');
        if ($type)
        {
            $data['makes'] = $this->mHome->getMakes($type);
        }
        else
        {
            $data['carMakes'] = $this->mHome->getMakes('car');
            $data['boatMakes'] = $this->mHome->getMakes('boat');
            $data['motoMakes'] = $this->mHome->getMakes('moto');
            $data['atvMakes'] = $this->mHome->getMakes('atv');
            $data['rvMakes'] = $this->mHome->getMakes('rv');
            $data['trailerMakes'] = $this->mHome->getMakes('trailer');
        }
        
        $data['latestTags'] = $this->mHome->getTags('latest');
        $data['randomTags'] = $this->mHome->getTags('random');
        
        Layout::view('vHome', $data);
    }
}