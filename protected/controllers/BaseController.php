<?php
function array_convert_chinese(&$input){
    $input = ChineseTrans::trad($input);
}
class BaseController  extends CController{

    /**
     * <head> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
     * @property {String} ieDocMode
     */
    public $ieDocMode = 'IE=edge';

    public $breadcrumbs = null;
    public $baseUrl = null;
    public $imageUrl = null;
    public $imagesUrl = null;
    public $current_uri = null;
    public $language = null;
    public $language_name = null;
    public $language_id = null;
    public $session = null;
    public $cookie_domain = null;
    public $cookie_path = null;
    public $mainImagesabsuPath = null;
    public $cc = null;
    public $cart = null;
    public $order = null;
    public $curr_page = null;
    public $navigation = null;//NavigationHistory
    public $customers_advertiser = null;
    public $customers_ad_click_id = null;
    public $error = array();
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
    public $nofollowedindexed = false;
    //current store id
    public $sysCurrStoreId = 4 ;
    public $affiliate_clickthroughs_id = null;
    public $affiliate_clientbrowser= null;
    public $affiliate_clientdate = null;
    public $affiliate_clientip = null;
    public $affiliate_ref = null;
    public $authCustomer = null;

    public $mainTabIndex = 0;
    public $body_class = 'w-1000';

    const MSG_ERROR = 'error';
    const MSG_SUCCESS ='success';
    const MSG_NOTICE = 'notice';

    /* ClickTale */
    public $show_clicktale_condition = array(
        '',
        '6-days-east-coast-deluxe-tour-package-a.html',
        '13-day-usa-east-west-hawaii-new-york-shopping-a-tour.html',
        '7-day-east-coast-5-cities-niagara-falls-deep-tour.html',
        '3-day-washington-dc-philadelphia-thousand-island-and-niagara-falls-tour.html',
        'one-day-new-york-tour-ll.html',
        '7-day-bus-tour-of-mt-rushmore-and-yellowstone-bus-tour.html',
        '1-day-los-angeles-city-tour.html',
        '10-day-tellowstone-west-walk-powell-sfo-yosemite-tour.html'
    );
    public $show_clicktale = false;

    /**
     * all message
     * @var array
     */
    protected $messages = array();

    /**
     * parameters for site click
     */
    // the parameter that identify the click source, default 'clk_source'
    public $paramSource = 'clk_source';
    // the parameter that identify the click term, default 'clk_term'
    public $paramTerm = 'clk_term';

    /**
     * parameter for affiliate
     */
    public $is_affiliate_site_request = false;
    public $affiliateSiteHelper = null;
    public $affiliateSiteId = null; // affiliate_id of site
    public $common_client_script  = true;

    public function __construct($id,$module = null){
        //2013-12-20, eric, check whether the request comes from a affiliate site(user use a sub-domain)
        $this->is_affiliate_site_request = DomainListener::isAffiliateSiteRequest();
        //20140505 vincent . filter XSS str for PCI scan.
        $_GET = secure_array($_GET);
        $_POST = secure_array($_POST);

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

        $this->sysCurrStoreId = isset(Yii::app()->params['storeId']) ?Yii::app()->params['storeId'] : 2 ;

		$host = $_SERVER['HTTP_HOST'];
		//fix domain
		if($host == 'toursforfun.com'){
			$this->redirect('http://cn.toursforfun.com' . Yii::app()->request->requestUri, true, 301);
		}
//        if(TOURS_HOMEPAGE_BAIDU_AUDIT == 'on'){
//            $this->defineNewLanguageID();
//        }else{
//            $this->defineLanguageID();
//        }

        if(LANGUAGE_ID == 'tw'){
            Yii::app()->language = 'zh_cn';
            $this->language = Yii::app()->language;
            $this->language_name = 'tchinese';
            $this->language_id = Yii::app()->params['languageId'];
            if(!$_REQUEST['raw'] && !$_POST['raw'] && !$_GET['raw']) {
                $_REQUEST = $this->convertArrayToSChinese($_REQUEST);
                $_GET = $this->convertArrayToSChinese($_GET);
                $_POST = $this->convertArrayToSChinese($_POST);
            }
        }else{
            Yii::app()->language = 'zh_cn';
            $this->language = Yii::app()->language;
            $this->language_name = 'schinese';
            $this->language_id = Yii::app()->params['languageId'];
        }

        //make a site click by eric
        try {
            $this->makeSiteClickStat();
        } catch (Exception $e) {
            //will handle after soon
        }

        //we just add catalogSecureUrl,catalogUrl to params. this config will overrite urlManager's config. by vincent
//        Yii::app()->urlManager->secureHost = Yii::app()->params['catalogSecureUrl'];
//        Yii::app()->urlManager->commonHost = Yii::app()->params['catalogUrl'];

        parent::__construct($id,$module);

        $this->layout = 'common_layout';

        $this->breadcrumbs = new Breadcrumbs();
        $this->breadcrumbs->add('首页', $this->createUrl('site/index'));

        $this->session = Yii::app()->getSession();
        $this->session->open();

        //customer_id session
        $this->session['customer_id'] = Yii::app()->user->id;

//        $this->navigation = new NavigationHistory();
        $this->baseUrl = Yii::app()->baseUrl;

        $this->cookie_domain = Yii::app()->params['cookieDomain'];
        $this->cookie_path = '/';

        $this->mainImagesabsuPath = Yii::app()->params['mainImagesabsuPath'];

        //Group Ordering
        if(!defined('GROUP_BUY_ON')) define('GROUP_BUY_ON',true); //Group Ordering power switch
//        if(!defined('GROUP_MIN_GUEST_NUM'))define('GROUP_MIN_GUEST_NUM',10); //the minumium guests for group ordering
//        if(!defined('DISCOUNT_PERCENTAGE'))define('DISCOUNT_PERCENTAGE', 0.05); //discount percentage 5%
//        if(!defined('DECIMAL_DIGITS'))define('DECIMAL_DIGITS',0); //the decimal fordiscount, rouded up the decimal
//        if(!defined('GROUP_BUY_INCLUDE_SUB_TOUR'))define('GROUP_BUY_INCLUDE_SUB_TOUR',true); //whether including short itinerary tours which don't have rooms option

        //yahoo tracking
//        if (isset($_GET["OVRAW"])) {
//            $_GET["utm_source"] = 'yahoo';
//            $_GET["utm_medium"] = 'cpc';
//            $_GET["utm_term"] = $_GET["OVRAW"];
//            $_GET["utm_content"] = "OVADID=".$_GET["OVADID"]."  OVKWID=". $_GET["OVKWID"];
//            $_GET["utm_campaign"] = $_GET["OVKEY"];
//        }

//        $cookie_expire = time() + AFFILIATE_COOKIE_LIFETIME;
//        //yiqifa tracking start
//        if (isset($_GET['source'])) {
//            switch($_GET['source']) {
//                case "emar":
//                    $yiqifa_interId = '';
//                    if (isset($_GET['cid']) && isset($_GET['wi'])) {
//                        if ((int)$_GET['cid'] == 17282){
//                            $_GET["utm_source"] = 'emar_cps';
//                            $_GET["utm_medium"] = 'emar_cps';
//                            $yiqifa_interId = '51dbacbde03b3d4992a2e574';
//                        } elseif ((int)$_GET['cid'] == 17283) {
//                            $_GET["utm_source"] = 'emar_yigao';
//                            $_GET["utm_medium"] = 'emar_yigao';
//                            $yiqifa_interId = '51dbacc4e03b3d4992a2e575';
//                        }
//
//                        if (isset($_GET['target']) && $_GET['target'] != ''){
//                            $yiqifa_redirect = $_GET['target'];
//                        }
//
//                        //设置亿起发cookie
//                        $CHttpCookie                                = new CHttpCookie('yiqifa_cid', (int) Yii::app()->request->getParam('cid'));
//                        $CHttpCookie->expire                        = $cookie_expire;
//                        $CHttpCookie->path                          = $this->cookie_path;
//                        $CHttpCookie->domain                        = $this->cookie_domain;
//                        Yii::app()->request->cookies['yiqifa_cid']  = $CHttpCookie;
//
//                        $CHttpCookie                                = new CHttpCookie('yiqifa_wi', Yii::app()->request->getParam('wi'));
//                        $CHttpCookie->expire                        = $cookie_expire;
//                        $CHttpCookie->path                          = $this->cookie_path;
//                        $CHttpCookie->domain                        = $this->cookie_domain;
//                        Yii::app()->request->cookies['yiqifa_wi']   = $CHttpCookie;
//
//                        $CHttpCookie                                    = new CHttpCookie('yiqifa_interId', $yiqifa_interId);
//                        $CHttpCookie->expire                            = $cookie_expire;
//                        $CHttpCookie->path                              = $this->cookie_path;
//                        $CHttpCookie->domain                            = $this->cookie_domain;
//                        Yii::app()->request->cookies['yiqifa_interId']  = $CHttpCookie;
//
//                        //取消 其他cookie
//                        Yii::app()->request->cookies->remove('linkTech_aid');
//                        setcookie('linkTech_aid', null, 0, $this->cookie_path, $this->cookie_domain);
//                    }
//                    break;
//                case "linkTech":
//                    if ($_REQUEST['a_id']) {
//                        $_GET["utm_source"] = 'linkTech';
//                        $_GET["utm_medium"] = 'linkTech';
//
//                        if (isset($_GET['target']) && $_GET['target'] != ''){
//                            $yiqifa_redirect = $_GET['target'];
//                        }
//
//                        // 设置领克特cookie
//                        $CHttpCookie                                    = new CHttpCookie('linkTech_aid', Yii::app()->request->getParam('a_id'));
//                        $CHttpCookie->expire                            = time() + 2592000;
//                        $CHttpCookie->path                              = $this->cookie_path;
//                        $CHttpCookie->domain                            = $this->cookie_domain;
//                        Yii::app()->request->cookies['linkTech_aid']    = $CHttpCookie;
//
//                        // 取消 其他cookie
//                        Yii::app()->request->cookies->remove('yiqifa_cid');
//                        setcookie('yiqifa_cid', null, 0, $this->cookie_path, $this->cookie_domain);
//                        Yii::app()->request->cookies->remove('yiqifa_wi');
//                        setcookie('yiqifa_wi', null, 0, $this->cookie_path, $this->cookie_domain);
//                        Yii::app()->request->cookies->remove('yiqifa_interId');
//                        setcookie('yiqifa_interId', null, 0, $this->cookie_path, $this->cookie_domain);
//                    }
//                    break;
//            }
//
//            // 取消网站联盟 cookie
//            Yii::app()->request->cookies->remove('affiliate_ref');
//            setcookie('affiliate_ref', null, 0, $this->cookie_path, $this->cookie_domain);
//            Yii::app()->request->cookies->remove('is_affiliate_site');
//            setcookie('is_affiliate_site', null, 0, $this->cookie_path, $this->cookie_domain);
//
//            // 取消成果网 cookie
//            Yii::app()->request->cookies->remove('chanet_sid');
//            setcookie('chanet_sid', null, 0, $this->cookie_path, $this->cookie_domain);
//
//            // 取消多麦网 cookie
//            Yii::app()->request->cookies->remove('duomai_euid');
//            setcookie('duomai_euid', null, 0, $this->cookie_path, $this->cookie_domain);
//            Yii::app()->request->cookies->remove('duomai_mid');
//            setcookie('duomai_mid', null, 0, $this->cookie_path, $this->cookie_domain);
//
//            // 删除潘博网 cookie
//            Yii::app()->request->cookies->remove('pampa_cid');
//            setcookie('pampa_cid', null, 0, '/', Yii::app()->params['cookieDomain']);
//            Yii::app()->request->cookies->remove('pampa_aid');
//            setcookie('pampa_aid', null, 0, '/', Yii::app()->params['cookieDomain']);
//            Yii::app()->request->cookies->remove('pampa_ref');
//            setcookie('pampa_ref', null, 0, '/', Yii::app()->params['cookieDomain']);
//        }

        //yiqifa tracking end

        //query: ref=308777&utm_source=308777&utm_medium=af&utm_term=detaillink&affiliate_banner_id=1
//        if (isset($_GET["utm_source"])) {
//            $advertiser = $_GET["utm_source"];
//            $customers_advertiser1 = $_GET["utm_source"];
//            $utm_medium = $_GET["utm_medium"];
//            $utm_term = $_GET["utm_term"];
//            $utm_content = $_GET["utm_content"];
//            $utm_campaign = $_GET["utm_campaign"];
//            if($utm_campaign != '' && $utm_term == ''){
//                $utm_term = $utm_campaign;
//            }
//            $sql_data_array = array(
//                'campaign_source' => tep_db_input($customers_advertiser1),
//                'utm_medium' => tep_db_input($utm_medium),
//                'utm_term' => tep_db_input($utm_term),
//                'utm_content' => tep_db_input($utm_content),
//                'utm_campaign' => tep_db_input($utm_campaign),
//                'click_date' => new CDbExpression('NOW()'),
//                'ip' => tep_get_ip_address()
//            );
//            // @author tuzki.zhang@toursforfun.com
//            // exclude duplicate add_click data
//            if (
//                empty(Yii::app()->request->cookies['customers_ad_click_id']->value)
//                || Yii::app()->request->cookies['customers_advertiser']->value != $sql_data_array['campaign_source']
//                || Yii::app()->request->cookies['utm_medium']->value != $sql_data_array['utm_medium']
//                || Yii::app()->request->cookies['utm_term']->value != $sql_data_array['utm_term']
//                || Yii::app()->request->cookies['utm_content']->value != $sql_data_array['utm_content']
//                || Yii::app()->request->cookies['utm_campaign']->value != $sql_data_array['utm_campaign']
//            ) {
//                $ad_click_model = new AdClick;
//                $ad_click_model->attributes = $sql_data_array;
//                $ad_click_model->insert();
//                $add_click_cookies = array(
//                    'utm_medium' => new CHttpCookie('utm_medium', $ad_click_model->utm_medium),
//                    'utm_term'=> new CHttpCookie('utm_term', $ad_click_model->utm_term),
//                    'utm_content' => new CHttpCookie('utm_content', $ad_click_model->utm_content),
//                    'utm_campaign' => new CHttpCookie('utm_campaign', $ad_click_model->utm_campaign),
//                );
//                foreach ($add_click_cookies as $key => $add_click_cookie) {
//                    $add_click_cookie->expire                                 = $cookie_expire;
//                    $add_click_cookie->path                                   = $this->cookie_path;
//                    $add_click_cookie->domain                                 = $this->cookie_domain;
//                    Yii::app()->request->cookies[$key] = $add_click_cookie;
//                }
//                $customers_ad_click_id1 = $ad_click_model->ad_click_id;
//
//                if (empty(Yii::app()->request->cookies['customers_advertiser']->value) || $_GET['utm_source']) {
//                    $CHttpCookie                                         = new CHttpCookie('customers_advertiser', $customers_advertiser1);
//                    $CHttpCookie->expire                                 = $cookie_expire;
//                    $CHttpCookie->path                                   = $this->cookie_path;
//                    $CHttpCookie->domain                                 = $this->cookie_domain;
//                    Yii::app()->request->cookies['customers_advertiser'] = $CHttpCookie;
//
//                    $CHttpCookie                                            = new CHttpCookie('customers_ad_click_id', $customers_ad_click_id1);
//                    $CHttpCookie->expire                                    = $cookie_expire;
//                    $CHttpCookie->path                                      = $this->cookie_path;
//                    $CHttpCookie->domain                                    = $this->cookie_domain;
//                    Yii::app()->request->cookies['customers_ad_click_id']   = $CHttpCookie;
//                }
//            }
//        }

        //Customer comes back and is registered in cookie
//        if (!empty(Yii::app()->request->cookies['customers_advertiser']->value)) {
//            $this->customers_advertiser = Yii::app()->request->cookies['customers_advertiser']->value;
//            $this->customers_ad_click_id = Yii::app()->request->cookies['customers_ad_click_id']->value;
//        }

        //Set Cookie referer_url
//        if (!isset($_COOKIE['referer_url'])) {
//            if ($_SERVER['HTTP_REFERER'] && !preg_match('/'.$_SERVER['HTTP_HOST'].'/i',$_SERVER['HTTP_REFERER']) ) {
//                $referer_url11 = $_SERVER['HTTP_REFERER'];
//                setcookie('referer_url', $referer_url11, time()+ AFFILIATE_COOKIE_LIFETIME, $this->cookie_path, $this->cookie_domain);
//            }
//        }

        //amit added for store cookies for affilaite sales and Ad Tracker start
//        $this->affiliate_clientdate = date("Y-m-d H:i:s");
//        $this->affiliate_clientbrowser = $_SERVER["HTTP_USER_AGENT"];
//        $this->affiliate_clientip = $_SERVER["REMOTE_ADDR"];
//        $affiliate_clientreferer = $_SERVER["HTTP_REFERER"];

        //try{
//        if (($_GET['ref'] || $_POST['ref'])) {
//            if($_GET['ref']){
//                $affiliate_ref = intval($_GET['ref']);
//            }else{
//                $affiliate_ref = intval($_POST['ref']);
//            }
//            $is_new = false;
//            if($_GET['is_new'] == '1' || $_POST['is_new'] == '1'){
//                $is_new = true;
//            }
//            if(!$is_new){
//                //if affiliate url is old, find the corresponding new customer_id
//                $mapping = CustomerNewOldMapping::model()->findByAttributes(array('old_customer_id'=>$affiliate_ref));
//                //if(!$mapping->customer_id)throw new Exception('customer_id not found!');
//                $affiliate_customer_data = Customer::model()->findByPk($mapping->customer_id);
//                $affiliate_ref = (int)$mapping->customer_id;
//            }else{
//                $affiliate_customer_data = Customer::model()->findByPk($affiliate_ref);
//            }
//
//            $affiliate_products_id = 1;
//            if(isset($_GET['product_id']) && intval($_GET['product_id'])>0){
//                $affiliate_products_id = intval($_GET['product_id']);
//            }elseif(isset($_GET['products_id']) && intval($_GET['products_id'])>0){
//                $affiliate_products_id = intval($_GET['products_id']);
//            }
//
//            $affiliate_banner_id = 1;
//            if(isset($_GET['affiliate_banner_id']) && intval($_GET['affiliate_banner_id'])>0){
//                $affiliate_banner_id = intval($_GET['affiliate_banner_id']);
//            }
//
//            $affiliate_data = Affiliate::model()->findByPk($affiliate_ref);
//            //amit added to fixed auto insert if no recored on affilaite table
//            if(!empty($affiliate_customer_data) && empty($affiliate_data)){//if no recored on affilaite table do insert
//                $sql_data_array = array(
//                    'homepage' => '',
//                    'company' => '',
//                    'company_taxid' => '',
//                    'commission_percent' => 0.00,
//                    'payment_check' => '',
//                    'payment_paypal' => '',
//                    'payment_bank_name' => '',
//                    'payment_bank_branch_number' => '',
//                    'payment_bank_swift_code' => '',
//                    'payment_bank_account_name' => '',
//                    'payment_bank_account_number' => '',
//                    'lft' => '1',
//                    'rgt' => '2',
//                    'root' => $affiliate_ref,
//                    'newsletter' => '1',
//                    'commission_by_margin_20' => 0.00,
//                    'commission_by_margin_25' => 0.00,
//                    'commission_by_margin_30' => 0.00,
//                    'commission_by_margin_plush' => 0.00,
//                );
//                $affiliate_model = new Affiliate;
//                $affiliate_model->attributes = $sql_data_array;
//                $affiliate_model->setPrimaryKey($affiliate_ref);
//                $affiliate_model->insert();
//                //find data after insert
//                $affiliate_data = Affiliate::model()->findByPk($affiliate_ref);
//            }
//
//            if(!empty($affiliate_data)){
//                if($affiliate_banner_id != 1){
//                    $affiliate_banner_data = AffiliateBanner::model()->findByPk($affiliate_banner_id);
//                    if(empty($affiliate_banner_data)){
//                        $affiliate_banner_id = 1;
//                    }
//                }
//
//                $sql_data_array = array(
//                    'affiliate_id' => $affiliate_ref,
//                    'click_date' => $this->affiliate_clientdate,
//                    'browser' => $this->affiliate_clientbrowser,
//                    'ip' => $this->affiliate_clientip,
//                    'referer' => $affiliate_clientreferer,
//                    'product_id' => $affiliate_products_id,
//                    'affiliate_banner_id' => $affiliate_banner_id
//                );
//                $aff_click_model = new AffiliateClick;
//                $aff_click_model->attributes = $sql_data_array;
//                $aff_click_model->insert();
//
//                //Set Cookie affiliate_clickthroughs_id
//                $affiliate_clickthroughs_id = $aff_click_model->affiliate_click_id;
//                setcookie('affiliate_clickthroughs_id', $affiliate_clickthroughs_id, time()+ AFFILIATE_COOKIE_LIFETIME, $this->cookie_path, $this->cookie_domain);
//
//                //Set Cookie if the customer comes back and orders it counts
//                // 如果已经存在一起发的统计这里就不再次统计，反之亦然
//                Yii::app()->request->cookies->remove('yiqifa_cid');
//                setcookie('yiqifa_cid', null, 0, $this->cookie_path, $this->cookie_domain);
//                Yii::app()->request->cookies->remove('yiqifa_wi');
//                setcookie('yiqifa_wi', null, 0, $this->cookie_path, $this->cookie_domain);
//                Yii::app()->request->cookies->remove('yiqifa_interId');
//                setcookie('yiqifa_interId', null, 0, $this->cookie_path, $this->cookie_domain);
//
//                Yii::app()->request->cookies->remove('linkTech_aid');
//                setcookie('linkTech_aid', null, 0, $this->cookie_path, $this->cookie_domain);
//
//                Yii::app()->request->cookies->remove('chanet_sid');
//                setcookie('chanet_sid', null, 0, $this->cookie_path, $this->cookie_domain);
//
//                Yii::app()->request->cookies->remove('duomai_euid');
//                setcookie('duomai_euid', null, 0, $this->cookie_path, $this->cookie_domain);
//                Yii::app()->request->cookies->remove('duomai_mid');
//                setcookie('duomai_mid', null, 0, $this->cookie_path, $this->cookie_domain);
//
//                Yii::app()->request->cookies->remove('pampa_cid');
//                setcookie('pampa_cid', null, 0, '/', Yii::app()->params['cookieDomain']);
//                Yii::app()->request->cookies->remove('pampa_aid');
//                setcookie('pampa_aid', null, 0, '/', Yii::app()->params['cookieDomain']);
//                Yii::app()->request->cookies->remove('pampa_ref');
//                setcookie('pampa_ref', null, 0, '/', Yii::app()->params['cookieDomain']);
//
//                Yii::app()->request->cookies->remove('customers_advertiser');
//                setcookie('customers_advertiser', null, 0, $this->cookie_path, $this->cookie_domain);
//                Yii::app()->request->cookies->remove('customers_ad_click_id');
//                setcookie('customers_ad_click_id', null, 0, $this->cookie_path, $this->cookie_domain);
//
//                // 设置网站联盟cookie
//                $CHttpCookie                                    = new CHttpCookie('affiliate_ref', $affiliate_ref);
//                $CHttpCookie->expire                            = time() + AFFILIATE_COOKIE_LIFETIME;
//                $CHttpCookie->path                              = $this->cookie_path;
//                $CHttpCookie->domain                            = $this->cookie_domain;
//                Yii::app()->request->cookies['affiliate_ref']   = $CHttpCookie;
//
//                //Banner has been clicked, update stats
//                if($affiliate_banner_id > 1 && $affiliate_ref > 1){
//                    $today = date('Y-m-d');
//                    $sql = "select * from " . AffiliateBannerHistory::tableName() . " where affiliate_banner_id = '" . $affiliate_banner_id  . "' and  affiliate_id = '" . $affiliate_ref . "' and history_date = '" . $today . "'";
//                    $banner_stats_query = Yii::app()->db->createCommand($sql)->query();
//                    if (count($banner_stats_query) > 0){
//                        $sql_update = "update " . AffiliateBannerHistory::tableName() . " set clicks = clicks + 1 where affiliate_banner_id = '" . $affiliate_banner_id . "' and affiliate_id = '" . $affiliate_ref. "' and history_date = '" . $today . "'";
//                        Yii::app()->db->createCommand($sql_update)->query();
//                    }else{
//                        $sql_data_array = array(
//                            'affiliate_banner_id' => $affiliate_banner_id,
//                            'product_id' => $affiliate_products_id,
//                            'affiliate_id' => $affiliate_ref,
//                            'clicks' => '1',
//                            'history_date' => $today
//                        );
//                        $affiliate_banner_history_model = new AffiliateBannerHistory;
//                        $affiliate_banner_history_model->attributes = $sql_data_array;
//                        $affiliate_banner_history_model->insert();
//                    }
//                }
//            }
//        }
//        //}catch (Exception $e){
//            ////do nothing
//        //}
//        //amit added for store cookies for affilaite sales and Ad Tracker End
//
//        //Customer comes back and is registered in cookie
//        if($_COOKIE['affiliate_clickthroughs_id']){
//			$this->affiliate_clickthroughs_id = $_COOKIE['affiliate_clickthroughs_id'];
//		}
//
//        //affiliate statistical optimization
//        if(!isset($_COOKIE['no_ref'])){
//            $no_ref_ids = explode(',',NO_REF_IDS);
//            if(isset($_GET['ref'])) {
//                if(!in_array(intval($_GET['ref']),$no_ref_ids)){
//                    setcookie('no_ref', 1, time()+NO_REF_LIFETIME, $this->cookie_path, $this->cookie_domain);
//                }
//            }else{
//                if (empty(Yii::app()->request->cookies['affiliate_ref']->value) || !in_array(Yii::app()->request->cookies['affiliate_ref']->value, $no_ref_ids)) {
//                    setcookie('no_ref', 1, time()+NO_REF_LIFETIME, $this->cookie_path, $this->cookie_domain);
//                }
//            }
//        }
//
//        if ($this->common_client_script) {
//
//            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/style/base.css");
//            Yii::app()->getClientScript()->registerScriptFile( '/js/DD_belatedPNG.js', CClientScript::POS_HEAD, array('on' => 'lte IE 6') );
//            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/base.css");
//            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.js");
//            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/base.js");
//            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/big5.js");
//
//        }
//
//        //online user check
//        /**
//         * ENABLE_PING_CUSTOMER saved a last_activity for customer to check customer is online
//         * THe clear action must implement with linux cron job for performance.
//         * DELETE FROM customer_online WHERE last_activity < DATE_SUB(NOW() , INTERVAL 600 SECOND)
//         * @auther vincent.
//         */
//        //define('PING_CUSTOMER_ENABLE', true);
//        if(defined('PING_CUSTOMER_ENABLE') && PING_CUSTOMER_ENABLE == true){
//            if(!Yii::app()->user->isGuest){
//                CustomerOnline::model()->updateActivity(Yii::app()->user->id);
//            }
//            /*
//            $clearActivity = defined('PING_CUSTOMER_CLEARUP') && PING_CUSTOMER_CLEARUP == true ? true :false;
//            $clearInterval = defined('PING_CUSTOMER_INTERVAL') && is_numeric(PING_CUSTOMER_INTERVAL) ? intval(PING_CUSTOMER_INTERVAL) : 600;
//            if($clearActivity == true){
//                CustomerOnline::model()->clearup($clearInterval);
//            }*/
//        }
//
//        //add after login redirect url by Tuzki 2013-4-18 start
//        if($_SERVER['REQUEST_METHOD'] != 'POST' && $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
//            $webroot_handle = opendir(Yii::getPathOfAlias('webroot'));
//            $patterns = array();
//            while(false !== ($dirname = readdir($webroot_handle))) {
//                if(is_dir($dirname)) {
//                    $patterns[] = '/^\/'.$dirname.'\//i';
//                }
//            }
//            $this->current_uri = Yii::app()->request->hostInfo . Yii::app()->request->requestUri;
//            $patterns = array_merge($patterns, array(
//                "/\/images\//i",
//                "/\/login\.php/i",
//                "/\/account\/login/i",
//                "/\/account\/checkStatus/i",
//                "/\/logoff\.php/i",
//                "/\/account\/logout/i",
//                "/\/create_account\.php/i",
//                "/\/account\/register/i",
//                '/\/password_forgotten\.php/i',
//                '/\/account\/forgottenPassword/i',
//                '/\/account\/accountGuestLogin/i',
//                '/.*\/captcha/i'
//            ));
//            $matched = FALSE;
//            foreach($patterns as $pattern) {
//                if(preg_match($pattern, $this->current_uri)) {
//                    $matched = TRUE;
//                    break;
//                }
//            }
//            if(!$matched) {
//                $cookies = Yii::app()->request->getCookies();
//                $after_login = unserialize($cookies['after_login']->value);
//                $len = count($after_login);
//                if($len > 2) {
//                    $after_login = array_slice($after_login, $len-2);
//                    $len = 2;
//                }
//                if($after_login[$len - 1] != $this->current_uri) {
//                    if($len > 1) {
//                        array_shift($after_login);
//                    }
//                    $after_login[] = $this->current_uri;
//                }
//                $after_login = serialize($after_login);
//                setcookie('after_login', $after_login, 0, $this->cookie_path, $this->cookie_domain);
//            }
//        }
//        if(!empty($yiqifa_redirect)){
//            $this->redirect($yiqifa_redirect);
//        }
//        //add after login redirect url by Tuzki 2013-4-18 end
//
//        //set page title
//        $this->setPageTitle('途风旅游网（携程旗下）- 美国,加拿大,欧洲,澳洲出境旅游旅行团服务专家');
//
//        //Omar add show ClickTale Statistical code
//        if(in_array(trim($_SERVER['REDIRECT_URL'], '/'), $this->show_clicktale_condition)){
//            $this->show_clicktale = true;
//        }
    }

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
     * @todo initialize affiliate site
     * @name initializeAffiliateSite
     */
    private function initializeAffiliateSite($id,$module){
        $this->affiliateSiteHelper = AffiliateSiteHelper::getInstance();
        // 在网站联盟里面先清空亿起发数据
        Yii::app()->request->cookies->remove('customers_advertiser');
        setcookie('customers_advertiser', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('customers_ad_click_id');
        setcookie('customers_ad_click_id', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('yiqifa_cid');
        setcookie('yiqifa_cid', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('yiqifa_wi');
        setcookie('yiqifa_wi', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('yiqifa_interId');
        setcookie('yiqifa_interId', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('linkTech_aid');
        setcookie('linkTech_aid', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('chanet_sid');
        setcookie('chanet_sid', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('duomai_euid');
        setcookie('duomai_euid', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('duomai_mid');
        setcookie('duomai_mid', null, 0, $this->cookie_path, $this->cookie_domain);
        Yii::app()->request->cookies->remove('pampa_cid');
        setcookie('pampa_cid', null, 0, '/', Yii::app()->params['cookieDomain']);
        Yii::app()->request->cookies->remove('pampa_aid');
        setcookie('pampa_aid', null, 0, '/', Yii::app()->params['cookieDomain']);
        Yii::app()->request->cookies->remove('pampa_ref');
        setcookie('pampa_ref', null, 0, '/', Yii::app()->params['cookieDomain']);

        //if the request comes from an illegal affiliate domain, then return a 404 error of main site
        if(!$this->affiliateSiteHelper->isValidDomain()){
            // get main site host
            $_host = DomainListener::getMainSiteHost();
            // jump to the 404 page of the main site
            $this->redirect('http://'.$_host.'/error404.html');
            exit;
        }
        $this->affiliateSiteId = $this->affiliateSiteHelper->getAffiliateId();
        // check whether the current page is a valid list page
        // if not, then redirect to 404 page of current site
        if(!$this->affiliateSiteHelper->isValidPage()){
            $this->redirect('/error404.html');
            exit;
        }
        
        //Make all define accessible to all pages
        Configuration::loadConstants();

        $this->imagesUrl = cdn_images_url();
        $this->imageUrl = cdn_image_url();

        $this->sysCurrStoreId = isset(Yii::app()->params['storeId']) ?Yii::app()->params['storeId'] : 2 ;
        $language = $this->affiliateSiteHelper->getPageLanguage();
        define('LANGUAGE_ID' , $language);
        setcookie('language', $language, time() + 3600*24*365*10, '/', Yii::app()->params['cookieDomain']);
        if(LANGUAGE_ID == 'tw'){
            Yii::app()->language = 'zh_cn';
            $this->language = Yii::app()->language;
            $this->language_name = 'tchinese';
            $this->language_id = Yii::app()->params['languageId'];
            if(!$_REQUEST['raw'] && !$_POST['raw'] && !$_GET['raw']) {
                $_REQUEST = $this->convertArrayToSChinese($_REQUEST);
                $_GET = $this->convertArrayToSChinese($_GET);
                $_POST = $this->convertArrayToSChinese($_POST);
            }
        }else{
            Yii::app()->language = 'zh_cn';
            $this->language = Yii::app()->language;
            $this->language_name = 'schinese';
            $this->language_id = Yii::app()->params['languageId'];
        }

        //change configs for Affiliate Website
        if(IS_DEV_SITE || IS_QA_SITE){
            Yii::app()->params['catalogSecureUrl'] = 'http://'.$_SERVER['HTTP_HOST'];
        }else{
            Yii::app()->params['catalogSecureUrl'] = 'https://'.$_SERVER['HTTP_HOST'];
        }
        if(IS_QA_SITE){
            Yii::app()->params['domain'] = '.qa.toursforfun.com';
        }
        Yii::app()->params['catalogUrl'] = 'http://'.$_SERVER['HTTP_HOST'];;

        //we just add catalogSecureUrl,catalogUrl to params. this config will overrite urlManager's config. by vincent
        Yii::app()->urlManager->secureHost = Yii::app()->params['catalogSecureUrl'];
        Yii::app()->urlManager->commonHost = Yii::app()->params['catalogUrl'];

        parent::__construct($id,$module);

        $this->layout = 'affiliate_common_layout';

        $this->breadcrumbs = new Breadcrumbs();
        $this->breadcrumbs->add(Yii::t('main','首页'), $this->createUrl('site/index'));

        $this->session = Yii::app()->getSession();
        $this->session->open();

        //customer_id session
        $this->session['customer_id'] = Yii::app()->user->id;

        $this->navigation = new NavigationHistory();
        $this->baseUrl = Yii::app()->baseUrl;

        $this->cookie_domain = Yii::app()->params['cookieDomain'];
        $this->cookie_path = '/';

        $this->mainImagesabsuPath = Yii::app()->params['mainImagesabsuPath'];

        //Group Ordering
        if(!defined('GROUP_BUY_ON')) define('GROUP_BUY_ON',true); //Group Ordering power switch
        if(!defined('GROUP_MIN_GUEST_NUM'))define('GROUP_MIN_GUEST_NUM',10); //the minumium guests for group ordering
        if(!defined('DISCOUNT_PERCENTAGE'))define('DISCOUNT_PERCENTAGE', 0.05); //discount percentage 5%
        if(!defined('DECIMAL_DIGITS'))define('DECIMAL_DIGITS',0); //the decimal fordiscount, rouded up the decimal
        if(!defined('GROUP_BUY_INCLUDE_SUB_TOUR'))define('GROUP_BUY_INCLUDE_SUB_TOUR',true); //whether including short itinerary tours which don't have rooms option

        //Set Cookie if the customer comes back and orders it counts
        $CHttpCookie                                        = new CHttpCookie('is_affiliate_site', 1);
        $CHttpCookie->expire                                = time() + AFFILIATE_COOKIE_LIFETIME;
        $CHttpCookie->path                                  = $this->cookie_path;
        $CHttpCookie->domain                                = $this->cookie_domain;
        Yii::app()->request->cookies['is_affiliate_site']   = $CHttpCookie;

        $CHttpCookie                                    = new CHttpCookie('affiliate_ref', $this->affiliateSiteHelper->getAffiliateId());
        $CHttpCookie->expire                            = time() + AFFILIATE_COOKIE_LIFETIME;
        $CHttpCookie->path                              = $this->cookie_path;
        $CHttpCookie->domain                            = $this->cookie_domain;
        Yii::app()->request->cookies['affiliate_ref']   = $CHttpCookie;

        //add css and js by Tuzki
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/base.css");
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.js");
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/base.js");
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/big5.js");

        //set page meta info
        $this->setPageTitle($this->affiliateSiteHelper->getPageTitle());
        $this->pageDesc = $this->affiliateSiteHelper->getPageDescription();
        $this->pageKey = $this->affiliateSiteHelper->getPageKeywords();
    }

    /**
     * check current client is a China clent
     * @return boolean
     */
    public function isChinaClient(){
        $client_ip = Yii::app()->request->getUserHostAddress();
        Yii::import('webeez.extensions.Ip2city');
        $ip = new Ip2city();
        return $ip->checkIpInRange($client_ip);
    }

    /**
     * check current client is a Canada client
     * @return boolean
     */
    public function isCanadaClient(){
        //return true ; //disabled cause the SINA service is too slow .
        $client_ip = Yii::app()->request->getUserHostAddress();
        Yii::import('webeez.extensions.Ip2city');
        $ip2City = new Ip2city();
        $ipData = $ip2City->getIpData($client_ip);
        return is_array($ipData) && $ipData['isoCode'] == 'CA' ? true : false;
    }

    /**
     * check current is crawler
     * @return boolean
     */
    public function isCrawler() {
        $agent= strtolower($_SERVER['HTTP_USER_AGENT']);
        if (!empty($agent)) {
            $spiderSite= array(
                'baiduspider','baiduspider-image','baiduspider-video','baiduspider-news',
                'baiduspider-favo','baiduspider-cpro','baiduspider-ads',
                'baiduspider','googlebot','googlebot-news','googlebot-image',
                'googlebot-video','googlebot-mobile','mediapartners-google',
                'adsbot-google','360spider','360spider-image','360spider-video',
                'sosospider','slurp','youdaobot','yodaobot','sogou news spider',
                'sogou web spider','sogou inst spider','sogou spider2','sogou blog',
                'sogou news spider','sogou orion spider','bingbot','adidxbot','msnbot',
                'bingpreview','yisouspider','ia_archiver','easouspider','jikespider'
            );
            foreach($spiderSite as $val) {
                if (strpos($agent, $val) !== false) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * With the baidu review
     */
    public function defineNewLanguageID()
    {
        $host = $_SERVER['HTTP_HOST'];
        if (isset($_GET['language']) && $_GET['language'] == 'sc' || $host == 'cn.toursforfun.com') {
            $_lang = 'sc';
        } else {
            $_lang = 'tw';
        }
        setcookie('language', $_lang, time() + 3600 * 24 * 365 * 10, '/', Yii::app()->params['cookieDomain']);
        if (IS_PROD_SITE == true) {
            //for prod site
            if ($_lang == 'sc') {
                Yii::app()->params['catalogUrl'] = 'http://cn.toursforfun.com';
                Yii::app()->params['catalogSecureUrl'] = 'https://cn.toursforfun.com';
            } else {
                Yii::app()->params['catalogUrl'] = 'http://www.toursforfun.com';
                Yii::app()->params['catalogSecureUrl'] = 'https://www.toursforfun.com';
            }
        }
        define('LANGUAGE_ID', $_lang);
        return $_lang;
    }
    /**
     * AS marketing required . Spider skip the language guess process
     */
    public function defineLanguageID(){
        $host = $_SERVER['HTTP_HOST'];
        $domainLanguage = $host == 'cn.toursforfun.com' || $host == 'gb.toursforfun.com' || $host == 'toursforfun.com' ? 'sc':'tw';

        if($this->isCrawler()){
            define('LANGUAGE_ID' , $domainLanguage);
            return $domainLanguage; //crawler will not check language setting
        }

		$_lang = 'tw';

		if(isset($_GET['language'])) {
			$getLanguage = strtolower(trim($_GET['language']));
			$_lang = $getLanguage == 'sc' || $getLanguage == 'cn'? 'sc':'tw';
		}else if(isset($_COOKIE['language']) &&  ( $_COOKIE['language'] == 'sc' || $_COOKIE['language'] == 'tw' )){
			$_lang = $_COOKIE['language'];
		}else{
			if($this->isChinaClient()){
				$_lang = 'sc';
			}else{
				$_lang = 'tw';
			}
		}
		setcookie('language' ,$_lang ,time() +3600*24*365*10,'/',Yii::app()->params['cookieDomain']);
		if(IS_PROD_SITE == true){
			//for prod site
			if($_lang == 'sc'){
				Yii::app()->params['catalogUrl'] = 'http://cn.toursforfun.com';
				Yii::app()->params['catalogSecureUrl'] = 'https://cn.toursforfun.com';
			}else{
				Yii::app()->params['catalogUrl'] = 'http://www.toursforfun.com';
				Yii::app()->params['catalogSecureUrl'] = 'https://www.toursforfun.com';
			}
			if($_lang != $domainLanguage){
				$jump = $_lang == 'sc'? 'http://cn.toursforfun.com'.Yii::app()->request->requestUri : 'http://www.toursforfun.com'.Yii::app()->request->requestUri;
				$this->redirect($jump);
			}
		}
		define('LANGUAGE_ID' , $_lang);
		return $_lang;
	}


    public function init(){
//        $this->cart = new ShoppingCart();
//        $this->order = new Orders();
//        $this->customers_advertiser = Yii::app()->request->cookies['customers_advertiser']->value;
//        $this->customers_ad_click_id = Yii::app()->request->cookies['customers_ad_click_id']->value;
//
//        if(!Yii::app()->user->isGuest) {
//            $this->authCustomer = Customer::model()->findByPk(Yii::app()->user->id);
//        }
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
     * Create full or relative URL with a GET params forward
     * @param string $route
     * @param boolean $absoluteUrl
     * @param mix $exclude
     * @param array $include
     * @param string $https schema to use (e.g. http, https). If empty, the schema used for the current request will be used.
     * @author vincent.mi@toursforfun.com (2012-2-24)
     */
    private function _createUrlWithForward($route,$absoluteUrl = false ,$exclude = null , $include = null,$https = ''){
        //$forwardParams = $_GET;
        $forwardParams = array();
        if($exclude != null){
            if(is_string($exclude)){
                $exclude = explode(',',$exclude);
            }
            $exclude =(array)$exclude;
            foreach($exclude as $key){
                unset($forwardParams[$key]);
            }
        }

        if( $include != null || $include != ''){
            $insertArr = array();
            if(is_string($include)){
                parse_str($include , $insertArr);
            }else{
                $insertArr = (array)$include;
            }
            $forwardParams = array_merge($forwardParams , $insertArr);
        }
        if($absoluteUrl == true){
            return $this->createAbsoluteUrl($route,$forwardParams,$https);
        }else{
            return $this->createUrl($route,$forwardParams,$https);
        }
    }

    /**
     * Create full url (with host name) with a GET params forward
     * @param string $route route string
     * @param mix $exclude array or string separator with ',', point which keys will not be forward.
     * @param array $include array(key=>value),insert or replace old value from GET
     * @param string $https schema to use (e.g. http, https). If empty, the schema used for the current request will be used.
     * @author vincent.mi@toursforfun.com (2012-2-24)
     */
    public function createAbsoluteUrlWithForward($route,$exclude = null , $include = null ,$https = ''){
        if($_SERVER['HTTP_HOST']=='www.tours4fun.com' || $_SERVER['HTTP_HOST']=='secure.tours4fun.com' || $_SERVER['HTTP_HOST'] == 'www.tours4fun.es') {
            return $this->_createUrlWithForward($route,true,$exclude,$include,$https);
        }else{
            return $this->_createUrlWithForward($route,false,$exclude,$include,$https);
        }
    }

    /**
     * Create url with a GET params forword
     * @param string $route route string
     * @param mix $exclude array or string separator with ',', point which keys will not be forward.
     * @param array $include array(key=>value),insert or replace old value from GET
     * @param string $https schema to use (e.g. http, https). If empty, the schema used for the current request will be used.
     * @author vincent.mi@toursforfun.com (2012-2-24)
     */
    public function createUrlWithForward($route,$exclude = null , $include = null,$https=''){
        return $this->_createUrlWithForward($route,false,$exclude,$include,$https);
    }

    /**
     * set the main tab selected index
     * @author vincent
     * @param int $index
     */
    public function setMainTabIndex($index){
        $this->mainTabIndex = intval($index);
    }

    /**
     * Show flash messages
     *
     * @param string $buttons Buttons to show in flash message. Defualt ok. Add multiple buttons with | delimiter
     * @author Gihan S <gihanshp@gmail.com>
     */
    public function actionDisplayFlashMessage($buttons = 'ok'){
        $this->layout = '//layouts/blank_layout';
        $showButtons = array();
        if(trim($buttons)){
            $buttons = explode('|', $buttons);
            $showButtons = array_filter($buttons);
        }
        $this->render('//base/flash', array(
            'showButtons'=>$showButtons
        ));
    }

    /**
     * (non-PHPdoc) pass $data to layout page
     * @see CController::render()
     * @auth vincent
     */
    public function render($view,$data=null,$return=false, $trans = true){
        if($this->beforeRender($view)){
            $output=$this->renderPartial($view,$data,true);
            if(($layoutFile=$this->getLayoutFile($this->layout))!==false){
                $data['content'] = $output;
                $output=$this->renderFile($layoutFile,$data,true);
            }
            $this->afterRender($view,$output);
            $output=$this->processOutput($output,$trans);
            if($return)
                return $output;
            else
                echo $output;
        }
    }

    /**
     * convert GET/POST/REQUEST to schinese
     * @param unknown $data
     * @return string
     */
    public function convertArrayToSChinese(&$data){
        return is_array($data)?array_map(array($this,'convertArrayToSChinese'),$data):ChineseTrans::simp($data);
    }

    /**
     * Convert to schinese or tchinese
     * if you are using echo something please call this method first
     * @param unknown $content
     * @return mixed
     */
    public function convertChinese($content){
        if(LANGUAGE_ID == 'tw'){
            if(is_array($content)){
                array_walk_recursive($content, 'array_convert_chinese');
            }else{
                $content = ChineseTrans::trad($content);
            }
        }
        return $content;
    }

    /* when use unionpay pay,Because of the signature characters involved, so can't be converted by Panda */
    public function processOutput($output, $trans = true){
        $output = parent::processOutput($output);
        if(LANGUAGE_ID == 'tw' && $trans === true){
            $output = ChineseTrans::trad($output);
        }
        return $output;
    }

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
    public function registerClientFiles(array $scripts){
        $cs = Yii::app()->clientScript;
        foreach($scripts as $key=>$files){
            foreach($files as $file){
                $baseUrl = Yii::app()->baseUrl;

                // check url is absolute or not
                if(preg_match('@^https?://@', $file))
                        $baseUrl = '';

                // add / prefix if not there
                $file = trim($file);
                if($file[0] != '/')
                    $file = '/'.$file;

                switch($key){
                    case 'js':
                        $cs->registerScriptFile($baseUrl.$file);
                        break;
                    case 'css':
                        $cs->registerCssFile($baseUrl.$file);
                        break;
                }
            }
        }
    }

    /**
     * add a flash message ,flash message was saved in sesssion.
     * @param string $type MSG_SUCCESS
     * @param string $message
     */
    public function addFlash($message,$type = self::MSG_SUCCESS,$clear = false){
        if($clear == false){
            $old_msg = Yii::app()->user->getFlash($type,'');
            if($old_msg!=''){
                $message = $old_msg.'<br/>'.$message;
            }
        }
        Yii::app()->user->setFlash($type,$message);
    }

    /**
     * Display error message 。
     * @param int $fadeOut 0,no fade .how many second to fade this message ,no effect to error message.
     * @param int $type null ,for all type,BaseController::MSG_ERROR or other type
     */
    public function displayMessage($fadeOut= 0 , $type = null){
        $html = '';$js = '';
        $id = uniqid('msg');
        $jsAnimate = '.animate({opacity: 1.0}, '.$fadeOut.'000).slideUp("fast");';

        //display all flash
        $flashMessages = Yii::app()->user->getFlashes();
        if ($flashMessages) {
            foreach($flashMessages as $key => $message) {
                $html .= '<p class="msgbox msgbox-'.$key.'" id="'.$id.'_flash_'.$key.'"><span>'.$message.'</span></p>';
                //$html .= '<div class="'.$key.'box" id="'.$id.'_flash_'.$key.'"><h2>'.ucwords($key).'</h2><p>'.$message.'</p></div>';
                $js.= 'jQuery("#'.$id.'_flash_'.$key.'")'.$jsAnimate;
            }
        }
        /*
        if(($type == null || $type == self::MSG_ERROR) && !empty($this->messages[self::MSG_SUCCESS])){
            $html .= '<div class="successbox" id="'.$id.'_success"><h2>Successful</h2><p>';
            foreach($this->messages[self::MSG_SUCCESS] as $msg){
                $html .= $msg['message'].'<br />' ;
            }
            $html.="</div>";
            $js.= 'jQuery("#'.$id.'_success")'.$jsAnimate;
        }

        if(($type == null || $type == self::MSG_NOTICE) && !empty($this->messages[self::MSG_NOTICE])){
            $html .= '<div class="noticebox" id="'.$id.'_notice"><h2>Notice</h2><p>';
            foreach($this->messages[self::MSG_NOTICE] as $msg){
                $html .= $msg['message'].'<br />' ;
            }
            $html.="</div>";
            $js.= 'jQuery("#'.$id.'_notice")'.$jsAnimate;
        }

        if(($type == null || $type == self::MSG_ERROR) && !empty($this->messages[self::MSG_ERROR])){
            $html .= '<div class="errorbox" id="'.$id.'_error"><h2>Error</h2><p>';
            foreach($this->messages[self::MSG_ERROR] as $msg){
                $html .= $msg['message'].'<br />' ;
            }
            $html.="</div>";
            //$js.= 'jQuery("#'.$id.'_error")'.$jsAnimate; //dont remove error msg
        } */
        if($html!= ''){
            echo $html;
            if($fadeOut > 0 && $js != ''){
                echo '<script type="text/javascript">'.$js.'</script>';
            }
        }
    }

    /**
     * add a error message
     * @param string $key
     * @param string $message
     */
    public function addError($key, $message){
        if(isset($this->error[$key])){
            $this->error[$key].=','.$message;
        }else{
            $this->error[$key]=$message;
        }
    }

    /**
     * get errir message
     */
    public function getError(){
        return $this->error;
    }

    public function send($to, $subject, $content, $from = '', $reply='', $attachements = array()) {
        return Yii::app()->mailer->send(
            $this->convertChinese($to),
            $this->convertChinese($subject),
            $this->convertChinese($content),
            $this->convertChinese($from),
            $this->convertChinese($reply),
            $attachements
        );
    }

    /**
     * delete Fragment Cache
     * the option 'varyByRoute' must set false because the route character case does not regulate in the project, or it will no effect.
     * @param string $id COutputCache widget id which is used in view like : $this->beginCache($id, array('varyByRoute'=>false))
     * @return bool
      */
    public function deleteCache($id) {
        if(Yii::app()->hasComponent('cache')) {
            return Yii::app()->cache->delete('Yii.COutputCache.' . $id . '......');
        }
    }

    /**
     * @todo make a stat for site click
     * @name makeSiteClickStat
     * @param    none
     * @return void
     * @author eric.tao@toursforfun.com
     */
    private function makeSiteClickStat(){
        // check whether the current url is marked as a statistic url or not
        if(!(isset($_GET[$this->paramSource]) || isset($_GET[$this->paramTerm]))){
            return false;
        }

        // get parameters
        $source = Yii::app()->request->getParam($this->paramSource, NULL);
        $term = Yii::app()->request->getParam($this->paramTerm, NULL);
        if(!$source || !$term || !preg_match('/^[0-9A-Za-z_-]+$/', $source) || !preg_match('/^[0-9A-Za-z_-]+$/', $term)){
            // invalid request
            return;
        }

        // save click counts information
        SiteClick::saveCounts($source, $term);
        // save click source information on client
        SiteClickBusiness::updateClientCookie($source, $term);
    }

    /**
     * redirect after login
     */
    public function afterLogin()
    {
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
		}
	}

    /**
     * For cancelling the `forceMaster` option.
     *
     * @inheritdoc
     */
    protected function afterAction($action)
    {
        parent::afterAction($action);

        //Yii::app()->db->forceMaster = false;
    }

    public function filters()
    {
        return array(
            array(
                'webeez.classes.WebeezRequestFilter',
            )
        );
    }
}
