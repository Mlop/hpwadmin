<?php
error_reporting(E_ALL &~E_NOTICE &~E_STRICT);

define('WEBEEZ_APP' , dirname(__FILE__).DIRECTORY_SEPARATOR.'protected');

$config_dev = WEBEEZ_APP.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'dev.php' ;
$config_prod = WEBEEZ_APP.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'prod.php' ;
if(file_exists($config_dev)) {
    define('IS_DEV_SITE',true);
    define('IS_PROD_SITE',false);
    define('IS_QA_SITE',false);
    $config = include ($config_dev);
    define('YII_DEBUG',true);
    define('YII_TRACE_LEVEL',3);
    ini_set('display_errors','1');
} else {
    define('IS_DEV_SITE',false);
    if($_SERVER['HTTP_HOST'] == 'qa.toursforfun.com' || $_SERVER['HTTP_HOST'] == 'stg.toursforfun.com' || $_SERVER['HTTP_HOST'] == 'dev.toursforfun.com' || preg_match('/^(\w+\.)?qa\.toursforfun\.com$/',$_SERVER['HTTP_HOST'])){
        define('IS_PROD_SITE',false);
        define('IS_QA_SITE',true);
        define('YII_DEBUG',true);
        define('YII_TRACE_LEVEL',3);
        ini_set('display_errors','1');
    } else {
        define('IS_PROD_SITE',true);
        define('IS_QA_SITE',false);
        define('YII_DEBUG',false);
        define('YII_TRACE_LEVEL',0);
    }
    $config = include ($config_prod);
}

if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'act/availableSeckills')) {
    $config['components']['urlManager']['rules'] = array(
        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
    );
//    require WEBEEZ_LIB . DIRECTORY_SEPARATOR . 'webeez_api.php';
} else {
//    require WEBEEZ_LIB . DIRECTORY_SEPARATOR . 'webeez.php';
}
//require_once('system.yii');
require_once(YII_PATH.DIRECTORY_SEPARATOR.'yii.php');

/**
 * global alias you can use
 * Yii::import('webeez.extensions.WeebeezList') to import classes from lib
 */
Yii::setPathOfAlias('webeez', WEBEEZ_LIB);



date_default_timezone_set('Asia/Shanghai');

//define pre-import class path 
Yii::$classMap=array(
    'ImageHelper' => WEBEEZ_APP.DIRECTORY_SEPARATOR.'extensions'.DIRECTORY_SEPARATOR.'ImageHelper.php'  ,
);

//define  pre-import class path end

try {
    // Don't delete this line, it will be uncommented by the deployment script:
    //@@UNCOMMENT@@ require_once( WEBEEZ_APP . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'template.php');
    Yii::import('webeez.extensions.WebApplication');
    Yii::createApplication('WebApplication', $config)->run();
} catch(CHttpException $e){
    $uri = strtolower(Yii::app()->request->getPathInfo());

    //pass query string
    $get_querystring = array();
    foreach (explode("&", $_SERVER['QUERY_STRING']) as $tmp_arr_param) {
        $split_param = explode("=", $tmp_arr_param);
        if($split_param[1] != ''){
            $get_querystring[$split_param[0]] = urldecode($split_param[1]);
        }
    }

    $redirect_map = array(
        'about_us.php'=>Yii::app()->createUrl('page/About_Us'),
        'privacy-policy.php' => Yii::app()->createUrl('page/Privacypolicy'),
        'customer-agreement.php' => Yii::app()->createUrl('page/Customeragreement'),
        'acknowledgement_of_card_billing.php' => Yii::app()->createUrl('page/AcknowledgementOfCardBilling'),
        'cancellation-and-refund-policy.php' => Yii::app()->createUrl('page/CancellationAndRefundPolicy'),
        'copy-right.php' => Yii::app()->createUrl('page/Copyright'),
        'travel_insurance.php' => Yii::app()->createUrl('page/TravelInsurance'),
        'join_rewards4fun.php' => Yii::app()->createUrl('page/Rewards4Fun'),
        'careers.php' => Yii::app()->createUrl('page/Careers'),
        'faq.php' => Yii::app()->createUrl('page/FaqList'),
        'site-map.php'=>Yii::app()->createUrl('page/SiteMap'),
        'contact_us.php' => Yii::app()->createUrl('page/ContactUs'),
        'reviews.php' => Yii::app()->createUrl('page/reviews'),
        'newsletter_subscriber.php' => Yii::app()->createUrl('page/NewsLetterSubscribe'),
        'subscribe_unsubscribe.php' => Yii::app()->createUrl('page/NewsLetterUnsubscribe'),
        'pressroom.php' => Yii::app()->createUrl('page/PressRoom'),
        'press_release.php' => Yii::app()->createUrl('page/PressRelease'),
        'newsletters_archive_list.php' => Yii::app()->createUrl('page/NewslettersArchiveList', $get_querystring),
        'promotions.php' => Yii::app()->createUrl('page/Promotions'),
        'affiliate_newsletter.php' => Yii::app()->createUrl('page/AffiliateNewsletter'),
        'account.php' => Yii::app()->createUrl('account/Index'),
        'account_newsletters.php' => Yii::app()->createUrl('account/CutomerNewsLetterSubscribe'),
        'account_edit.php' => Yii::app()->createUrl('account/AccountEdit'),
        'affiliate-contact.php' => Yii::app()->createUrl('affiliates/AffiliateContact'),
        'affiliate-sales.php' => Yii::app()->createUrl('affiliates/AffiliateSales'),
        'address_book.php' => Yii::app()->createUrl('account/AddressBook'),
        'login.php' => Yii::app()->createUrl('account/AccountLogin'),
        'account.php' => Yii::app()->createUrl('account/Index'),
        'repeat-customer-program-faq.php' => Yii::app()->createUrl('repeatcustomer/RepeatCustomerProgramFaq'),
        'repeat-customer-summary.php' => Yii::app()->createUrl('repeatcustomer/RepeatCustomerSummary'),
        'repeat-customer-thank-you.php' => Yii::app()->createUrl('repeatcustomer/RepeatCustomerThankYou'),
        'feedback-approval.php' => Yii::app()->createUrl('rewards4fun/FeedbackApproval'),
        'all-articles.php' => Yii::app()->createUrl('page/AllArticles'),
        'my-points.php' => Yii::app()->createUrl('rewards4fun/MyPoints'),
        'points-action-description.php' => Yii::app()->createUrl('rewards4fun/PointsActionDescription'),
        'rewards4fun-terms.php' => Yii::app()->createUrl('rewards4fun/Rewards4funTerms'),
        'affiliate-faq.php' => Yii::app()->createUrl('affiliates/AffiliateFaq'),
        'affiliate-terms.php' => Yii::app()->createUrl('affiliates/AffiliateTerms'),
        'affiliate-payment.php' => Yii::app()->createUrl('affiliates/AffiliatePayment'),
        'affiliate-details.php'=>Yii::app()->createUrl('affiliates/AffiliateDetails'),
        'affiliate-summary.php' =>Yii::app()->createUrl('affiliates/AffiliateSummary'),
        'popup-affiliate-help.php' =>Yii::app()->createUrl('affiliates/PopupAffiliateHelp'),
        'refer-friends.php' =>Yii::app()->createUrl('affiliates/ReferFriends'),
        'affiliate-tour-widget.php' => Yii::app()->createUrl('affiliates/AffiliateTourWidget'),
        'affiliate-banners.php' => Yii::app()->createUrl('affiliates/AffiliateBanners'),
        'acknowledgement_of_card_billing.doc' => Yii::app()->baseUrl.'/image/doc/Acknowledgement_of_Card_Billing.doc',
        'acknowledgement_of_card_billing_es.doc' => Yii::app()->baseUrl.'/image/doc/Acknowledgement_of_Card_Billing_ES.doc',
        'cancellation_request_form.doc' => Yii::app()->baseUrl.'/image/doc/cancellation_request_form.doc',
        'credit_card_holder_verification.doc' => Yii::app()->baseUrl.'/image/doc/Credit_Card_Holder_Verification.doc',
        'credit_card_holder_verification_es.doc' => Yii::app()->baseUrl.'/image/doc/Credit_Card_Holder_Verification_ES.doc',
        'partner_application.xls' => Yii::app()->baseUrl.'/image/doc/Partner_Application.xls',
        'tours4Fun_booking_form.doc' => Yii::app()->baseUrl.'/image/doc/Tours4Fun_Booking_Form.doc',
        'tours4fun_fact_sheet.doc' => Yii::app()->baseUrl.'/image/doc/tours4fun_fact_sheet.doc',
        'partners.php' =>Yii::app()->createUrl('page/Partner'),
        'partner-application.php' =>Yii::app()->createUrl('page/PartnerApplication'),
        'group_buys.php' =>Yii::app()->createUrl('page/GroupBuys'),
        'church-getaway.php' =>Yii::app()->createUrl('page/ChurchGetaway'),
        'corporate-retreat.php' =>Yii::app()->createUrl('page/CorporateRetreats'),
        'class-trips.php'=> Yii::app()->createUrl('page/ClassTrip'),
        'senior-travel.php'=> Yii::app()->createUrl('page/SeniorTravel'),
        'family-reunion.php'=> Yii::app()->createUrl('page/FamilyReunion'),
        'other-groups.php'=> Yii::app()->createUrl('page/OtherGroup'),
        'blueprint-travel-on-dime.php' => Yii::app()->createUrl('page/BlueprintTravelOnDime'),
        'blueprint-favorite-piece-of-travel-gear.php' => Yii::app()->createUrl('page/BluePrintFavoritePieceOfTravelGear'),
        'blueprint.php' => Yii::app()->createUrl('page/BluePrint'),
        'coupons.php' => Yii::app()->createUrl('page/Coupons'),
        'loyal-customer-reward-program.php' => Yii::app()->createUrl('page/LoyalCustomerRewardProgram'),
        'iphone.php' => Yii::app()->createUrl('page/Iphone'),
        'payment-faq.php' => Yii::app()->createUrl('page/FaqList',array('cID'=>'1')),
        'redirect.php'=>Yii::app()->createUrl('page/Redirect',$get_querystring),
        'gift-certificates.php'=>Yii::app()->createUrl('page/GiftCertificates'),
        'shopping_cart.php'=>Yii::app()->createUrl('cart/list'),
        'new_shopping_cart.php'=>Yii::app()->createUrl('cart/new_list'),
        'gift_cards.php' => Yii::app()->createUrl('account/AccounGifthishistory'),
        'my_points_help.php' =>  Yii::app()->createUrl('rewards4fun/MyPointsHelp'),
        'rewards4fun_terms.php' => Yii::app()->createUrl('rewards4fun/Rewards4funTerms'),
        'help_travel_companion.php' => Yii::app()->createUrl('serviceCenter/view',array('cid'=>50)),
    );
    if(isset($redirect_map[$uri])){
        header("Location: ".$redirect_map[$uri]);
    }else{
        throw $e;
    }
}
