<?php
class BaseController extends CController
{
    /**
     * <head> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
     * @property {String} ieDocMode
     */
//    public $ieDocMode = 'IE=edge';

    public $breadcrumbs = null;
    public $baseUrl = null;
//    public $imageUrl = null;
//    public $imagesUrl = null;
//    public $current_uri = null;
//    public $language = null;
//    public $language_name = null;
//    public $language_id = null;
    public $session = null;
//    public $cookie_domain = null;
//    public $cookie_path = null;
    public $mainImagesabsuPath = null;
//    public $cc = null;
//    public $cart = null;
//    public $order = null;
//    public $curr_page = null;
//    public $navigation = null;//NavigationHistory
//    public $customers_advertiser = null;
//    public $customers_ad_click_id = null;
//    public $error = array();
    private static $_db;
    /**
     * save head tag <description>
     * @see BaseController::setPageDescription
     * @var string
     * @author vincent
     */
    public $pageDesc = null;
    /**
     * save head tag <description>
     * @see BaseController::setPageKeywords
     * @var string
     * @author vincent
     */
    public $pageKey = null;
//    public $nofollowedindexed = false;
    //current store id
//    public $sysCurrStoreId = 4 ;
//    public $affiliate_clickthroughs_id = null;
//    public $affiliate_clientbrowser= null;
//    public $affiliate_clientdate = null;
//    public $affiliate_clientip = null;
//    public $affiliate_ref = null;
//    public $authCustomer = null;

//    public $mainTabIndex = 0;
//    public $body_class = 'w-1000';

//    const MSG_ERROR = 'error';
//    const MSG_SUCCESS ='success';
//    const MSG_NOTICE = 'notice';

    /* ClickTale */
//    public $show_clicktale_condition = array(
//        '',
//        '6-days-east-coast-deluxe-tour-package-a.html',
//        '13-day-usa-east-west-hawaii-new-york-shopping-a-tour.html',
//        '7-day-east-coast-5-cities-niagara-falls-deep-tour.html',
//        '3-day-washington-dc-philadelphia-thousand-island-and-niagara-falls-tour.html',
//        'one-day-new-york-tour-ll.html',
//        '7-day-bus-tour-of-mt-rushmore-and-yellowstone-bus-tour.html',
//        '1-day-los-angeles-city-tour.html',
//        '10-day-tellowstone-west-walk-powell-sfo-yosemite-tour.html'
//    );
//    public $show_clicktale = false;

    /**
     * all message
     * @var array
     */
//    protected $messages = array();

    /**
     * parameters for site click
     */
    // the parameter that identify the click source, default 'clk_source'
//    public $paramSource = 'clk_source';
//    // the parameter that identify the click term, default 'clk_term'
//    public $paramTerm = 'clk_term';
//
//    /**
//     * parameter for affiliate
//     */
//    public $is_affiliate_site_request = false;
//    public $affiliateSiteHelper = null;
//    public $affiliateSiteId = null; // affiliate_id of site
//    public $common_client_script  = true;


    //parameter for checking guest. true/false
    public $isGuest = true;
    public $isLogin = true;
    //logined User object
    public $loginUser;

    protected $request;
    /**
     * @var array errors should show on views
     */
//    private $_errors = array();
    protected $returnData = "";

    public function __construct($id, $module = null)
    {
        $_GET = secure_array($_GET);
        $_POST = secure_array($_POST);
        $isGuest = Yii::app()->user->getIsGuest();
        Yii::app()->setLanguage('zh_cn');
        parent::__construct($id, $module);
        //使用模板
        $this->layout = 'common_layout';
        $this->breadcrumbs = new Breadcrumbs();
        $this->breadcrumbs->add('Home', Yii::app()->homeUrl);
        $this->request = Yii::app()->request;

        //登陆用户信息
        $this->session = Yii::app()->getSession();
        $this->session->open();
        $this->isLogin = $this->session['is_login'];
        $this->loginUser = $this->session['user'];
        $this->baseUrl = Yii::app()->baseUrl;

        // do not remove this, this configure is for website affiliate
//        if(IS_QA_SITE){
//            Yii::app()->params['domain'] = '.qa.toursforfun.com';
//        }
//        //the affiliate site does not support m site temporarily
//        if($this->is_affiliate_site_request){
//            $this->initializeAffiliateSite($id,$module);
//            return;
//        }else{
//            //Make all define accessible to all pages
//            Configuration::loadConstants();
//        }

        //check user agent
//        if (Yii::app()->mobileDetect->isMobile()  && !Yii::app()->mobileDetect->isTablet()){
//            $current_controller_action = Yii::app()->urlManager->parseUrl(Yii::app()->request);
//            $current_controller_arr = explode('/', $current_controller_action);
//            $current_controller = $current_controller_arr[0];
//            $current_action = $current_controller_arr[1];
//            /*$break_controller = array(
//                'product','page','banner','category', 'landingPage', 'visaService', 'TravelCompanion' ,'cart' ,'TourCustomize', 'account','myAccount'
//            );*/
//            $mController = array(
//                'site'
//            );
//            if (in_array($current_controller, $mController)){
//                $this->redirect(Yii::app()->params['mSiteUrl']);
//            }
//            //redirect to m site in product detail page
////            if ($current_controller == 'product' && $current_action == 'detail') {
////                $product_id = intval(Yii::app()->request->getParam('product_id'));
////                $whiteListProduct = new WhiteListProduct();
////                $whiteListProduct->appid = 10000000;
////                if ( $whiteListProduct->productExist($product_id) ) {
////                    $this->redirect(Yii::app()->params['mSiteUrl'] . '/productDetail.html?productId=' . $product_id);
////                }
////            }
//        }

        //we just add catalogSecureUrl,catalogUrl to params. this config will overrite urlManager's config. by vincent
//        Yii::app()->urlManager->secureHost = Yii::app()->params['catalogSecureUrl'];
//        Yii::app()->urlManager->commonHost = Yii::app()->params['catalogUrl'];

//
////        $this->navigation = new NavigationHistory();
//        $this->baseUrl = Yii::app()->baseUrl;
//
//        $this->cookie_domain = Yii::app()->params['cookieDomain'];
//        $this->cookie_path = '/';
//
//        $this->mainImagesabsuPath = Yii::app()->params['mainImagesabsuPath'];
    }

    protected function encodeResult($data = array(), $errorCode = 0)
    {
        return CJSON::encode(array('error'=>$errorCode, 'msg'=>$data));
    }

    /**
     * Returns a value indicating whether there is any validation error.
     * @param string $attribute attribute name. Use null to check all attributes.
     * @return boolean whether there is any error.
     */
//    public function hasErrors($attribute=null)
//    {
//        if($attribute===null)
//            return $this->_errors!==array();
//        else
//            return isset($this->_errors[$attribute]);
//    }
    /**
     * Returns the first error of the specified attribute.
     * @param string $attribute attribute name.
     * @return string the error message. Null is returned if no error.
     */
//    public function getError($attribute = null)
//    {
//        if (is_null($attribute)) {
//            return $this->_errors;
//        } else {
//            return isset($this->_errors[$attribute]) ? reset($this->_errors[$attribute]) : null;
//        }
//    }
    /**
     * Removes errors for all attributes or a single attribute.
     * @param string $attribute attribute name. Use null to remove errors for all attribute.
     */
//    public function clearErrors($attribute=null)
//    {
//        if($attribute===null)
//            $this->_errors=array();
//        else
//            unset($this->_errors[$attribute]);
//    }
    /**
     * Adds a new error to the specified attribute.
     * @param string $attribute attribute name
     * @param string $error new error message
     */
//    public function addError($attribute,$error)
//    {
//        $this->_errors[$attribute][]=$error;
//    }

    /**
     * display error
     * @param $attribute attribute name
     */
//    public function displayError($attribute)
//    {
//        $eArr = isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : array();
//
//        if (!empty($eArr)) {
//            $errStr = '<span style="color:red;">';
//            foreach ($eArr as $e) {
//                $errStr .= $e.'<br />';
//            }
//            $errStr .= '</span>';
//            echo $errStr;
//        }
//    }
    /**
     * 重写DB
     * @return 获得DB
     */
    public function getDbConnection(){
        if (self::$_db instanceof CDbConnection ) {
            return self::$_db;
        }
        self::$_db = Yii::app()->db;
        return self::$_db;
    }

    /**
     * (non-PHPdoc) pass $data to layout page
     * @see CController::render()
     * @auth vincent
     */
    public function render($view, $data = null, $return = false, $trans = true)
    {
        if ($this->beforeRender($view)) {
            $output = $this->renderPartial($view, $data, true);
            if (($layoutFile = $this->getLayoutFile($this->layout))!==false) {
                $data['content'] = $output;
                $output=$this->renderFile($layoutFile, $data, true);
            }
            $this->afterRender($view, $output);
            $output=$this->processOutput($output, $trans);
            if ($return) {
                return $output;
            } else {
                echo $output;
            }
        }
    }

    /**
     * 执行action前的动作，这里主要过滤需要登陆的情况
     * @param CAction $action
     * @return bool|void
     * @author vera.zhang 2015-02-25
     */
    protected function beforeAction($action)
    {
        $controller_id = $this->getId();
        $action_id = $this->getAction()->getId();
        $login_arr = array('incount', 'outcount');
        if (!$this->isLogin && in_array($controller_id, $login_arr)) {
            $this->redirect($this->createUrl('user/login'));
        }
        return true;
    }

    /**
     * set meta tag <description>
     * @param unknown $desc
     */
    public function setPageDescription($desc){
        $this->pageDesc = $desc;
    }

    public function setPageKeywords($keywords){
        $this->pageKey = $keywords;
    }

    /**
     * @todo initialize affiliate site
     * @name initializeAffiliateSite
     */
//    private function initializeAffiliateSite($id,$module){
//        $this->affiliateSiteHelper = AffiliateSiteHelper::getInstance();
//        // 在网站联盟里面先清空亿起发数据
//        Yii::app()->request->cookies->remove('customers_advertiser');
//        setcookie('customers_advertiser', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('customers_ad_click_id');
//        setcookie('customers_ad_click_id', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('yiqifa_cid');
//        setcookie('yiqifa_cid', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('yiqifa_wi');
//        setcookie('yiqifa_wi', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('yiqifa_interId');
//        setcookie('yiqifa_interId', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('linkTech_aid');
//        setcookie('linkTech_aid', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('chanet_sid');
//        setcookie('chanet_sid', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('duomai_euid');
//        setcookie('duomai_euid', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('duomai_mid');
//        setcookie('duomai_mid', null, 0, $this->cookie_path, $this->cookie_domain);
//        Yii::app()->request->cookies->remove('pampa_cid');
//        setcookie('pampa_cid', null, 0, '/', Yii::app()->params['cookieDomain']);
//        Yii::app()->request->cookies->remove('pampa_aid');
//        setcookie('pampa_aid', null, 0, '/', Yii::app()->params['cookieDomain']);
//        Yii::app()->request->cookies->remove('pampa_ref');
//        setcookie('pampa_ref', null, 0, '/', Yii::app()->params['cookieDomain']);
//
//        //if the request comes from an illegal affiliate domain, then return a 404 error of main site
//        if(!$this->affiliateSiteHelper->isValidDomain()){
//            // get main site host
//            $_host = DomainListener::getMainSiteHost();
//            // jump to the 404 page of the main site
//            $this->redirect('http://'.$_host.'/error404.html');
//            exit;
//        }
//        $this->affiliateSiteId = $this->affiliateSiteHelper->getAffiliateId();
//        // check whether the current page is a valid list page
//        // if not, then redirect to 404 page of current site
//        if(!$this->affiliateSiteHelper->isValidPage()){
//            $this->redirect('/error404.html');
//            exit;
//        }
//
//        //Make all define accessible to all pages
//        Configuration::loadConstants();
//
//        $this->imagesUrl = cdn_images_url();
//        $this->imageUrl = cdn_image_url();
//
//        $this->sysCurrStoreId = isset(Yii::app()->params['storeId']) ?Yii::app()->params['storeId'] : 2 ;
//        $language = $this->affiliateSiteHelper->getPageLanguage();
//        define('LANGUAGE_ID' , $language);
//        setcookie('language', $language, time() + 3600*24*365*10, '/', Yii::app()->params['cookieDomain']);
//        if(LANGUAGE_ID == 'tw'){
//            Yii::app()->language = 'zh_cn';
//            $this->language = Yii::app()->language;
//            $this->language_name = 'tchinese';
//            $this->language_id = Yii::app()->params['languageId'];
//            if(!$_REQUEST['raw'] && !$_POST['raw'] && !$_GET['raw']) {
//                $_REQUEST = $this->convertArrayToSChinese($_REQUEST);
//                $_GET = $this->convertArrayToSChinese($_GET);
//                $_POST = $this->convertArrayToSChinese($_POST);
//            }
//        }else{
//            Yii::app()->language = 'zh_cn';
//            $this->language = Yii::app()->language;
//            $this->language_name = 'schinese';
//            $this->language_id = Yii::app()->params['languageId'];
//        }
//
//        //change configs for Affiliate Website
//        if(IS_DEV_SITE || IS_QA_SITE){
//            Yii::app()->params['catalogSecureUrl'] = 'http://'.$_SERVER['HTTP_HOST'];
//        }else{
//            Yii::app()->params['catalogSecureUrl'] = 'https://'.$_SERVER['HTTP_HOST'];
//        }
//        if(IS_QA_SITE){
//            Yii::app()->params['domain'] = '.qa.toursforfun.com';
//        }
//        Yii::app()->params['catalogUrl'] = 'http://'.$_SERVER['HTTP_HOST'];;
//
//        //we just add catalogSecureUrl,catalogUrl to params. this config will overrite urlManager's config. by vincent
//        Yii::app()->urlManager->secureHost = Yii::app()->params['catalogSecureUrl'];
//        Yii::app()->urlManager->commonHost = Yii::app()->params['catalogUrl'];
//
//        parent::__construct($id,$module);
//
//        $this->layout = 'affiliate_common_layout';
//
//        $this->breadcrumbs = new Breadcrumbs();
//        $this->breadcrumbs->add(Yii::t('main','首页'), $this->createUrl('site/index'));
//
//        $this->session = Yii::app()->getSession();
//        $this->session->open();
//
//        //customer_id session
//        $this->session['customer_id'] = Yii::app()->user->id;
//
//        $this->navigation = new NavigationHistory();
//        $this->baseUrl = Yii::app()->baseUrl;
//
//        $this->cookie_domain = Yii::app()->params['cookieDomain'];
//        $this->cookie_path = '/';
//
//        $this->mainImagesabsuPath = Yii::app()->params['mainImagesabsuPath'];
//
//        //Group Ordering
//        if(!defined('GROUP_BUY_ON')) define('GROUP_BUY_ON',true); //Group Ordering power switch
//        if(!defined('GROUP_MIN_GUEST_NUM'))define('GROUP_MIN_GUEST_NUM',10); //the minumium guests for group ordering
//        if(!defined('DISCOUNT_PERCENTAGE'))define('DISCOUNT_PERCENTAGE', 0.05); //discount percentage 5%
//        if(!defined('DECIMAL_DIGITS'))define('DECIMAL_DIGITS',0); //the decimal fordiscount, rouded up the decimal
//        if(!defined('GROUP_BUY_INCLUDE_SUB_TOUR'))define('GROUP_BUY_INCLUDE_SUB_TOUR',true); //whether including short itinerary tours which don't have rooms option
//
//        //Set Cookie if the customer comes back and orders it counts
//        $CHttpCookie                                        = new CHttpCookie('is_affiliate_site', 1);
//        $CHttpCookie->expire                                = time() + AFFILIATE_COOKIE_LIFETIME;
//        $CHttpCookie->path                                  = $this->cookie_path;
//        $CHttpCookie->domain                                = $this->cookie_domain;
//        Yii::app()->request->cookies['is_affiliate_site']   = $CHttpCookie;
//
//        $CHttpCookie                                    = new CHttpCookie('affiliate_ref', $this->affiliateSiteHelper->getAffiliateId());
//        $CHttpCookie->expire                            = time() + AFFILIATE_COOKIE_LIFETIME;
//        $CHttpCookie->path                              = $this->cookie_path;
//        $CHttpCookie->domain                            = $this->cookie_domain;
//        Yii::app()->request->cookies['affiliate_ref']   = $CHttpCookie;
//
//        //add css and js by Tuzki
//        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/base.css");
//        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.js");
//        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/base.js");
//        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/big5.js");
//
//        //set page meta info
//        $this->setPageTitle($this->affiliateSiteHelper->getPageTitle());
//        $this->pageDesc = $this->affiliateSiteHelper->getPageDescription();
//        $this->pageKey = $this->affiliateSiteHelper->getPageKeywords();
//    }

    /**
     * check current client is a China clent
     * @return boolean
     */
//    public function isChinaClient(){
//        $client_ip = Yii::app()->request->getUserHostAddress();
//        Yii::import('webeez.extensions.Ip2city');
//        $ip = new Ip2city();
//        return $ip->checkIpInRange($client_ip);
//    }
//
//    /**
//     * check current client is a Canada client
//     * @return boolean
//     */
//    public function isCanadaClient(){
//        //return true ; //disabled cause the SINA service is too slow .
//        $client_ip = Yii::app()->request->getUserHostAddress();
//        Yii::import('webeez.extensions.Ip2city');
//        $ip2City = new Ip2city();
//        $ipData = $ip2City->getIpData($client_ip);
//        return is_array($ipData) && $ipData['isoCode'] == 'CA' ? true : false;
//    }

    /**
     * check current is crawler
     * @return boolean
     */
//    public function isCrawler() {
//        $agent= strtolower($_SERVER['HTTP_USER_AGENT']);
//        if (!empty($agent)) {
//            $spiderSite= array(
//                'baiduspider','baiduspider-image','baiduspider-video','baiduspider-news',
//                'baiduspider-favo','baiduspider-cpro','baiduspider-ads',
//                'baiduspider','googlebot','googlebot-news','googlebot-image',
//                'googlebot-video','googlebot-mobile','mediapartners-google',
//                'adsbot-google','360spider','360spider-image','360spider-video',
//                'sosospider','slurp','youdaobot','yodaobot','sogou news spider',
//                'sogou web spider','sogou inst spider','sogou spider2','sogou blog',
//                'sogou news spider','sogou orion spider','bingbot','adidxbot','msnbot',
//                'bingpreview','yisouspider','ia_archiver','easouspider','jikespider'
//            );
//            foreach($spiderSite as $val) {
//                if (strpos($agent, $val) !== false) {
//                    return true;
//                }
//            }
//        } else {
//            return false;
//        }
//    }

    /**
     * With the baidu review
     */
//    public function defineNewLanguageID()
//    {
//        $host = $_SERVER['HTTP_HOST'];
//        if (isset($_GET['language']) && $_GET['language'] == 'sc' || $host == 'cn.toursforfun.com') {
//            $_lang = 'sc';
//        } else {
//            $_lang = 'tw';
//        }
//        setcookie('language', $_lang, time() + 3600 * 24 * 365 * 10, '/', Yii::app()->params['cookieDomain']);
//        if (IS_PROD_SITE == true) {
//            //for prod site
//            if ($_lang == 'sc') {
//                Yii::app()->params['catalogUrl'] = 'http://cn.toursforfun.com';
//                Yii::app()->params['catalogSecureUrl'] = 'https://cn.toursforfun.com';
//            } else {
//                Yii::app()->params['catalogUrl'] = 'http://www.toursforfun.com';
//                Yii::app()->params['catalogSecureUrl'] = 'https://www.toursforfun.com';
//            }
//        }
//        define('LANGUAGE_ID', $_lang);
//        return $_lang;
//    }
    /**
     * AS marketing required . Spider skip the language guess process
     */
//    public function defineLanguageID(){
//        $host = $_SERVER['HTTP_HOST'];
//        $domainLanguage = $host == 'cn.toursforfun.com' || $host == 'gb.toursforfun.com' || $host == 'toursforfun.com' ? 'sc':'tw';
//
//        if($this->isCrawler()){
//            define('LANGUAGE_ID' , $domainLanguage);
//            return $domainLanguage; //crawler will not check language setting
//        }
//
//		$_lang = 'tw';
//
//		if(isset($_GET['language'])) {
//			$getLanguage = strtolower(trim($_GET['language']));
//			$_lang = $getLanguage == 'sc' || $getLanguage == 'cn'? 'sc':'tw';
//		}else if(isset($_COOKIE['language']) &&  ( $_COOKIE['language'] == 'sc' || $_COOKIE['language'] == 'tw' )){
//			$_lang = $_COOKIE['language'];
//		}else{
//			if($this->isChinaClient()){
//				$_lang = 'sc';
//			}else{
//				$_lang = 'tw';
//			}
//		}
//		setcookie('language' ,$_lang ,time() +3600*24*365*10,'/',Yii::app()->params['cookieDomain']);
//		if(IS_PROD_SITE == true){
//			//for prod site
//			if($_lang == 'sc'){
//				Yii::app()->params['catalogUrl'] = 'http://cn.toursforfun.com';
//				Yii::app()->params['catalogSecureUrl'] = 'https://cn.toursforfun.com';
//			}else{
//				Yii::app()->params['catalogUrl'] = 'http://www.toursforfun.com';
//				Yii::app()->params['catalogSecureUrl'] = 'https://www.toursforfun.com';
//			}
//			if($_lang != $domainLanguage){
//				$jump = $_lang == 'sc'? 'http://cn.toursforfun.com'.Yii::app()->request->requestUri : 'http://www.toursforfun.com'.Yii::app()->request->requestUri;
//				$this->redirect($jump);
//			}
//		}
//		define('LANGUAGE_ID' , $_lang);
//		return $_lang;
//	}


//    public function init(){
//        $this->cart = new ShoppingCart();
//        $this->order = new Orders();
//        $this->customers_advertiser = Yii::app()->request->cookies['customers_advertiser']->value;
//        $this->customers_ad_click_id = Yii::app()->request->cookies['customers_ad_click_id']->value;
//
//        if(!Yii::app()->user->isGuest) {
//            $this->authCustomer = Customer::model()->findByPk(Yii::app()->user->id);
//        }
//    }



    /**
     * Create full or relative URL with a GET params forward
     * @param string $route
     * @param boolean $absoluteUrl
     * @param mix $exclude
     * @param array $include
     * @param string $https schema to use (e.g. http, https). If empty, the schema used for the current request will be used.
     * @author vincent.mi@toursforfun.com (2012-2-24)
     */
//    private function _createUrlWithForward($route,$absoluteUrl = false ,$exclude = null , $include = null,$https = ''){
//        //$forwardParams = $_GET;
//        $forwardParams = array();
//        if($exclude != null){
//            if(is_string($exclude)){
//                $exclude = explode(',',$exclude);
//            }
//            $exclude =(array)$exclude;
//            foreach($exclude as $key){
//                unset($forwardParams[$key]);
//            }
//        }
//
//        if( $include != null || $include != ''){
//            $insertArr = array();
//            if(is_string($include)){
//                parse_str($include , $insertArr);
//            }else{
//                $insertArr = (array)$include;
//            }
//            $forwardParams = array_merge($forwardParams , $insertArr);
//        }
//        if($absoluteUrl == true){
//            return $this->createAbsoluteUrl($route,$forwardParams,$https);
//        }else{
//            return $this->createUrl($route,$forwardParams,$https);
//        }
//    }

    /**
     * Create full url (with host name) with a GET params forward
     * @param string $route route string
     * @param mix $exclude array or string separator with ',', point which keys will not be forward.
     * @param array $include array(key=>value),insert or replace old value from GET
     * @param string $https schema to use (e.g. http, https). If empty, the schema used for the current request will be used.
     * @author vincent.mi@toursforfun.com (2012-2-24)
     */
//    public function createAbsoluteUrlWithForward($route,$exclude = null , $include = null ,$https = ''){
//        if($_SERVER['HTTP_HOST']=='www.tours4fun.com' || $_SERVER['HTTP_HOST']=='secure.tours4fun.com' || $_SERVER['HTTP_HOST'] == 'www.tours4fun.es') {
//            return $this->_createUrlWithForward($route,true,$exclude,$include,$https);
//        }else{
//            return $this->_createUrlWithForward($route,false,$exclude,$include,$https);
//        }
//    }

    /**
     * Create url with a GET params forword
     * @param string $route route string
     * @param mix $exclude array or string separator with ',', point which keys will not be forward.
     * @param array $include array(key=>value),insert or replace old value from GET
     * @param string $https schema to use (e.g. http, https). If empty, the schema used for the current request will be used.
     * @author vincent.mi@toursforfun.com (2012-2-24)
     */
//    public function createUrlWithForward($route,$exclude = null , $include = null,$https=''){
//        return $this->_createUrlWithForward($route,false,$exclude,$include,$https);
//    }

    /**
     * set the main tab selected index
     * @author vincent
     * @param int $index
     */
//    public function setMainTabIndex($index){
//        $this->mainTabIndex = intval($index);
//    }

    /**
     * Show flash messages
     *
     * @param string $buttons Buttons to show in flash message. Defualt ok. Add multiple buttons with | delimiter
     * @author Gihan S <gihanshp@gmail.com>
     */
//    public function actionDisplayFlashMessage($buttons = 'ok'){
//        $this->layout = '//layouts/blank_layout';
//        $showButtons = array();
//        if(trim($buttons)){
//            $buttons = explode('|', $buttons);
//            $showButtons = array_filter($buttons);
//        }
//        $this->render('//base/flash', array(
//            'showButtons'=>$showButtons
//        ));
//    }



    /**
     * convert GET/POST/REQUEST to schinese
     * @param unknown $data
     * @return string
     */
//    public function convertArrayToSChinese(&$data){
//        return is_array($data)?array_map(array($this,'convertArrayToSChinese'),$data):ChineseTrans::simp($data);
//    }
//
//    /**
//     * Convert to schinese or tchinese
//     * if you are using echo something please call this method first
//     * @param unknown $content
//     * @return mixed
//     */
//    public function convertChinese($content){
//        if(LANGUAGE_ID == 'tw'){
//            if(is_array($content)){
//                array_walk_recursive($content, 'array_convert_chinese');
//            }else{
//                $content = ChineseTrans::trad($content);
//            }
//        }
//        return $content;
//    }
//
//    /* when use unionpay pay,Because of the signature characters involved, so can't be converted by Panda */
//    public function processOutput($output, $trans = true){
//        $output = parent::processOutput($output);
//        if(LANGUAGE_ID == 'tw' && $trans === true){
//            $output = ChineseTrans::trad($output);
//        }
//        return $output;
//    }

    /**
     * Wrapper to Yii::app()->clientScript->registerScriptFile
     * and Yii::app()->clientScript->registerCSSFile for ease the mass js and css
     * file registration
     *
     * Sample usage in a controller or controller's view file
     * <pre>
     * $this->registerClientFiles(array(
     *      'js'=>array('/js/base.js', 'http://cn.toursforfun.com/js/xbt.js')
     *      'css'=>array('/css/base.css', 'https://cn.toursforfun.com/css/mytours.css')
     * ));
     * </pre>
     *
     * @param array $scripts
     * @author Gihan S <gihanshp@gmail.com>
     */
//    public function registerClientFiles(array $scripts){
//        $cs = Yii::app()->clientScript;
//        foreach($scripts as $key=>$files){
//            foreach($files as $file){
//                $baseUrl = Yii::app()->baseUrl;
//
//                // check url is absolute or not
//                if(preg_match('@^https?://@', $file))
//                        $baseUrl = '';
//
//                // add / prefix if not there
//                $file = trim($file);
//                if($file[0] != '/')
//                    $file = '/'.$file;
//
//                switch($key){
//                    case 'js':
//                        $cs->registerScriptFile($baseUrl.$file);
//                        break;
//                    case 'css':
//                        $cs->registerCssFile($baseUrl.$file);
//                        break;
//                }
//            }
//        }
//    }
//
//    /**
//     * add a flash message ,flash message was saved in sesssion.
//     * @param string $type MSG_SUCCESS
//     * @param string $message
//     */
//    public function addFlash($message,$type = self::MSG_SUCCESS,$clear = false){
//        if($clear == false){
//            $old_msg = Yii::app()->user->getFlash($type,'');
//            if($old_msg!=''){
//                $message = $old_msg.'<br/>'.$message;
//            }
//        }
//        Yii::app()->user->setFlash($type,$message);
//    }
//
//    /**
//     * Display error message 。
//     * @param int $fadeOut 0,no fade .how many second to fade this message ,no effect to error message.
//     * @param int $type null ,for all type,BaseController::MSG_ERROR or other type
//     */
//    public function displayMessage($fadeOut= 0 , $type = null){
//        $html = '';$js = '';
//        $id = uniqid('msg');
//        $jsAnimate = '.animate({opacity: 1.0}, '.$fadeOut.'000).slideUp("fast");';
//
//        //display all flash
//        $flashMessages = Yii::app()->user->getFlashes();
//        if ($flashMessages) {
//            foreach($flashMessages as $key => $message) {
//                $html .= '<p class="msgbox msgbox-'.$key.'" id="'.$id.'_flash_'.$key.'"><span>'.$message.'</span></p>';
//                //$html .= '<div class="'.$key.'box" id="'.$id.'_flash_'.$key.'"><h2>'.ucwords($key).'</h2><p>'.$message.'</p></div>';
//                $js.= 'jQuery("#'.$id.'_flash_'.$key.'")'.$jsAnimate;
//            }
//        }
//        /*
//        if(($type == null || $type == self::MSG_ERROR) && !empty($this->messages[self::MSG_SUCCESS])){
//            $html .= '<div class="successbox" id="'.$id.'_success"><h2>Successful</h2><p>';
//            foreach($this->messages[self::MSG_SUCCESS] as $msg){
//                $html .= $msg['message'].'<br />' ;
//            }
//            $html.="</div>";
//            $js.= 'jQuery("#'.$id.'_success")'.$jsAnimate;
//        }
//
//        if(($type == null || $type == self::MSG_NOTICE) && !empty($this->messages[self::MSG_NOTICE])){
//            $html .= '<div class="noticebox" id="'.$id.'_notice"><h2>Notice</h2><p>';
//            foreach($this->messages[self::MSG_NOTICE] as $msg){
//                $html .= $msg['message'].'<br />' ;
//            }
//            $html.="</div>";
//            $js.= 'jQuery("#'.$id.'_notice")'.$jsAnimate;
//        }
//
//        if(($type == null || $type == self::MSG_ERROR) && !empty($this->messages[self::MSG_ERROR])){
//            $html .= '<div class="errorbox" id="'.$id.'_error"><h2>Error</h2><p>';
//            foreach($this->messages[self::MSG_ERROR] as $msg){
//                $html .= $msg['message'].'<br />' ;
//            }
//            $html.="</div>";
//            //$js.= 'jQuery("#'.$id.'_error")'.$jsAnimate; //dont remove error msg
//        } */
//        if($html!= ''){
//            echo $html;
//            if($fadeOut > 0 && $js != ''){
//                echo '<script type="text/javascript">'.$js.'</script>';
//            }
//        }
//    }

    /**
     * add a error message
     * @param string $key
     * @param string $message
     */
//    public function addError($key, $message){
//        if(isset($this->error[$key])){
//            $this->error[$key].=','.$message;
//        }else{
//            $this->error[$key]=$message;
//        }
//    }
//
//    /**
//     * get errir message
//     */
//    public function getError(){
//        return $this->error;
//    }

//    public function send($to, $subject, $content, $from = '', $reply='', $attachements = array()) {
//        return Yii::app()->mailer->send(
//            $this->convertChinese($to),
//            $this->convertChinese($subject),
//            $this->convertChinese($content),
//            $this->convertChinese($from),
//            $this->convertChinese($reply),
//            $attachements
//        );
//    }

    /**
     * delete Fragment Cache
     * the option 'varyByRoute' must set false because the route character case does not regulate in the project, or it will no effect.
     * @param string $id COutputCache widget id which is used in view like : $this->beginCache($id, array('varyByRoute'=>false))
     * @return bool
      */
//    public function deleteCache($id) {
//        if(Yii::app()->hasComponent('cache')) {
//            return Yii::app()->cache->delete('Yii.COutputCache.' . $id . '......');
//        }
//    }

    /**
     * @todo make a stat for site click
     * @name makeSiteClickStat
     * @param    none
     * @return void
     * @author eric.tao@toursforfun.com
     */
//    private function makeSiteClickStat(){
//        // check whether the current url is marked as a statistic url or not
//        if(!(isset($_GET[$this->paramSource]) || isset($_GET[$this->paramTerm]))){
//            return false;
//        }
//
//        // get parameters
//        $source = Yii::app()->request->getParam($this->paramSource, NULL);
//        $term = Yii::app()->request->getParam($this->paramTerm, NULL);
//        if(!$source || !$term || !preg_match('/^[0-9A-Za-z_-]+$/', $source) || !preg_match('/^[0-9A-Za-z_-]+$/', $term)){
//            // invalid request
//            return;
//        }
//
//        // save click counts information
//        SiteClick::saveCounts($source, $term);
//        // save click source information on client
//        SiteClickBusiness::updateClientCookie($source, $term);
//    }

    /**
     * redirect after login
     */
//    public function afterLogin()
//    {
        /*
        $now = Yii::app()->db->createCommand("SELECT NOW() cur_time")->queryScalar();
        $today = date('Y-m-d 00:00:00', strtotime($now));
        $expHis = Yii::app()->db->createCommand()
            ->select('customer_id')
            ->from(CustomerExperienceHistory::model()->tableName())
            ->where('customer_id = :customer_id AND type = :type AND created > :today')
            ->bindValues(
                array(
                    'customer_id' => Yii::app()->user->id,
                    'today' => $today,
                    'type' => CustomerExperienceHistory::EXP_PLUS_LOGIN
                )
            )
            ->queryScalar();
        if (!$expHis) {
            Customer::addExperience(Yii::app()->user->id, CustomerExperienceHistory::EXP_PLUS_LOGIN, $now);
        }
        $cookies = Yii::app()->request->getCookies();
        $after_login = unserialize($cookies['after_login']->value);

        // pop banner start
        $pop_banner = CJSON::decode(POP_BANNER_SETTINGS);
        $now = time();
        if ($pop_banner[LANGUAGE_ID]['active'] && ($now > $pop_banner[LANGUAGE_ID]['start_date']) && ($now < $pop_banner[LANGUAGE_ID]['end_date'])) {
            if (empty(Yii::app()->request->cookies['pop_banner_'.LANGUAGE_ID.$pop_banner[LANGUAGE_ID]['id']]->value)) {
                $CHttpCookie                                    = new CHttpCookie('pop_banner_'.LANGUAGE_ID.$pop_banner[LANGUAGE_ID]['id'], 'on');
                $CHttpCookie->expire                            = time() + $pop_banner[LANGUAGE_ID]['cookie_expire'];
                $CHttpCookie->path                              = $this->cookie_path;
                $CHttpCookie->domain                            = $this->cookie_domain;
                Yii::app()->request->cookies['pop_banner_'.LANGUAGE_ID.$pop_banner[LANGUAGE_ID]['id']] = $CHttpCookie;
            }
        } else {
            if (!empty(Yii::app()->request->cookies['pop_banner_'.LANGUAGE_ID.$pop_banner[LANGUAGE_ID]['id']]->value)) {
                Yii::app()->request->cookies->remove('pop_banner_'.LANGUAGE_ID.$pop_banner[LANGUAGE_ID]['id']);
                setcookie('pop_banner_'.LANGUAGE_ID.$pop_banner[LANGUAGE_ID]['id'], null, 0, $this->cookie_path, $this->cookie_domain);
            }
        }
        // pop banner end

		if($after_login && count($after_login) > 0) {
			$this->redirect(array_pop($after_login));
		} else {
			$this->redirect($this->createUrl('MyAccount/index'),true);
		}*/
//	}


}
