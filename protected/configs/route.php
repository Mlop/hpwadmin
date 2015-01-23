<?php
/**
 * URL Map Config
 */
return array(
//    'robots.txt' => 'robots/index',
    '/'=>'site/index',
    //{Images
//	array('class'=>'webeez.extensions.TffImageUrlRule'),
//    //}
//    //{AccountModule
//    'password_forgotten.php'=>'account/forgottenPassword',
//    'login.php'=>'account/login',
//	'logoff.php'=>'account/logout',
//	'account.php'=>'myAccount/index',
//    'create_account.php'=>'account/register',
//    //}
//	//{API
//	//'api/<version>/<service>'=>'api/execute',
//	array(
//		'class'=>'webeez.extensions.ApiUrlRule'
//	),
//	//}
//
//    //{ MyAccount
//    'account.php' => 'myAccount/index',
//    'account_history.php' => 'myAccount/myOrders',
//	//'cart/account_history.php' => 'myAccount/myOrders',
//    'orders_travel_companion.php' => 'myAccount/TravelCompanionOrders',
//    'eticket_list.php' => 'myAccount/myEticket',
//    'address_book.php' => 'myAccount/myAddress',
//    'orders_ask.php' => 'myAccount/myContact',
//    'account_edit.php' => 'myAccount/baseInfo',
//    'my_credits.php' => 'myAccount/myCredit',
//    'my_favorites.php' => 'myAccount/myFavorites',
//    'points_actions_history.php' => 'myAccount/myPoint',
//    'my_coupon.php' => 'myAccount/myCoupon',
//    'account_history_info.php' => 'MyAccount/OrderDetail',
//    'orders_travel_companion_info.php'=> 'myAccount/OrderTravelDetail',
//    'eticket.php' => 'MyAccount/myEticketDetail',
    //}
    // { Popular Tags by Evan
//    array(
//        'class'=>'application.extensions.PopularTagUrlRule',
//    ),
    // }
	//{pages\
//    '<path:(\w+\/)*>concat_<language:\w+>\W<filelist:.*>'=>'script/concat',
//	'javascript'=>'site/javascript',
//	'previews.html'=>'page/reviews',
//	'previews/page-<_p:\d+>.html'=>'page/reviews/page/<_p>',
//	'customer-agreement.php'=>'page/customer_agreement',
//	'privacy-policy.php'=>'page/privacy_policy',
//	'site-map.php'=>'page/siteMap',
//	'advanced_search_result.php'=>'category/search',
//	'tours-search/keywords/<w>'=>'category/search',
//	'search_suggestion'=>'category/searchSuggestion',
//	'guide_for_destination.php'=>'page/guideForDestination',
//    'acknowledgement_of_card_billing.php'=>'page/download_acknowledgement_card_billing',
//	'download_acknowledgement_card_billing.php'=>'page/download_acknowledgement_card_billing',
//	'cancellation-and-refund-policy.php'=>'page/cancellation_and_refund_policy',
//	'join_rewards4fun.php'=>'page/join_rewards4fun',
//	// {article
//	'default/cid-<cPath:\d+>' => 'article/seoNews',
//	'default' => 'article/seoNews',
//	'article/nid-<id:\d+>' => 'article/seoNewsView',
//    'air_tickets.php' => 'page/airTicket',
//	// }
//	'tours_announce.php' => 'article/announce',
//    'flight.html' => 'flight/index',
//	'tours_announce_article.php' => 'article/announceView',
//	'visa-help.php' => 'visaService/help',
//	'travel_insurance.php' => 'page/travel_insurance',
//    'travel_insurance_detail.php' => 'page/travelInsuranceDetail',
//	'allprods.php' => 'page/allprods',
//	'site-map.php' => 'page/siteMap',
//    'romantic_trip.php' => 'page/romanticTrip',
//	'magazine' => 'download/magazine',
//	'Ebook/' => 'download/ebook',
//	'affiliate.php' => 'affiliate/index',
//	'links.html' => 'page/links',
//    'parking.html' => 'page/park',
//    'about_us.php' => 'page/about_us',
//	'about-us.html' => 'page/about_us_new',
//    'business.html' => 'page/business',
//    'grow-up.html' => 'page/grow_up',
//    'praise.html' => 'page/word_of_mouth',
//    'team.html' => 'page/team',
//    'news.html' => 'page/news',
//    'join-us.html' => 'page/join_us',
//    'contact.html' => 'page/contact',
//    'cooperation.html' => 'page/cooperation',
//	'contact_us.php' => 'page/contact_us',
//	'copy-right.php' => 'page/copy_right',
//	'all_orders_products.php' => 'page/allOrdersProducts',
//	'expired_group_buys.php'=>'groupBuy/expires',
//
//	'refer_friends.php'=>'affiliate/referFriends',
//	'confirmation_newslleter_email.php'=>'account/validEmailBind',
//    'affiliate_news.php' => 'AffiliateNews/newsView',
//    'news_announce.php' => 'AffiliateNews/newsAnnounce',
//	//}
//	// { service center
//	'tour_question.php' => 'tourQuestion/post',
//	'service_center_article.php' => 'serviceCenter/view',
//	'service_center.php'=>'serviceCenter/index',
//	'charter_services.php'=>'serviceCenter/rent',
//	// }
//    // { integral mall
//    'mall' => 'integralMall/index',
//    'mall_search' => 'integralMall/ProductSearch',
//    'mall_category' => 'integralMall/ProductCategory',
//    'mall_product' => 'integralMall/ProductDetail',
//    'mall_confirm_order'  => 'integralMall/ConfirmOrder',
//    'mall_order_done' => 'integralMall/OrderSuccess',
//    'mall_announces' => 'integralMall/AnnounceList',
//    'mall_announce_detail' => 'integralMall/AnnounceDetail',
//    //}
//	'email_unsubscribe.php' => 'subscriber/unsubscribe',
//	'account_newsletters.php' => 'myAccount/newsletter',
//	'group_buys.php'=>'groupBuy/index',
//	'tours-departing-from-china-index'=>'tourCustomize/index',
//	'my_travel_companion.php'=>'travelCompanion/myTravelCompanion',
//	'individual_space.php'=>'travelCompanion/individualSpace',
//	'visa-service'=>'visaService/visa',
//    'visa_service_detail.php'=>'visaService/detail',
//	'customized_tours.php'=>'tourCustomize/create',
//	'customized_tours_index.php'=>'tourCustomize/introduction',
//    'customized_tours_review.php'=>'tourCustomizeReview/review',
//    'customize-tours'=>'travelCustomize/index',
//    'shopping_cart.php' => 'cart/list',
//	'checkout_confirmation.php' => 'cart/OrderVerify',
//	'checkout_payment.php' => 'cart/CheckoutPayment',
//	//'new_checkout_payment.php' => 'cart/NewCheckoutPayment',
//	'checkout_paypal.php' => 'cart/CheckoutPaypal',
//	'checkout_process.php' => 'cart/CheckoutProcess',
//	'checkout_success.php' => 'cart/CheckoutSuccess',
//	'paypal_notify.php' => 'cart/PaypalNotify',
//	'landingpage/<name:.*>/' => 'landingPage/index',
//    'activity/<name:.*>/<page:.*>' => 'landingPage/view/',
//    'activity/<name:.*>' => 'landingPage/view',
//	'album_list.php' => 'photoShare/index',
//	'album_show.php' => 'photoShare/show',
//    'album_share.php' => 'photoShare/shareTo',
//    'album_404.php' => 'photoShare/error',
//	'order_search.php' => 'account/QueryOrderNotRegister',
//    'australia-new-zealand' => 'site/australiaNewZealand',
//    'jiayuan-cooperation' => 'jiayuanCooperation/jiayuanCooperation',
//
//	array(
//				'class'=>'webeez.extensions.TffTravelCompanionUrlRule',
//				'language_id'=>3
//	),
//	array(
//				'class'=>'webeez.extensions.TffProductUrlRule',
//				'connectionID'=>'db',
//				'language_id'=>3
//	),
//	array(
//				'class'=>'webeez.extensions.AffiliateProductUrlRule',
//				'connectionID'=>'db',
//				'language_id'=>3
//	),



    //{  Easy Purchase By Robert
//    'easyBuy'=>'easyBuy/attractionPact',
//    'easyBuy/<id:\d+>'=>'easyBuy/attractionList',
//    //}
//
//
//
//	array(
//			'class'=>'webeez.extensions.ExpertUrlRule',
//			'connectionID'=>'db',
//			'language_id'=>3
//	),
//
//    //{ 欧洲旅游
//    'europe-all-tours/' => 'busTour/index',
//    'europe-bus-tours/' => 'busTour/map',
//    'cart/bus-tour-list/' => 'cart/BusTourList',
    //}

//    '<controller:\w+>/<action:\w+>-<question_id:\d+>-<tabid:\d+>'=>'<controller>/<action>', //fixed by demon
    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//    'special-price/vacation-packages/'=>'category/list/category_id/1091', // fixed by zyme
//    'Page/links/cat_<p:\d+>.html' => 'Page/links',
//
//
//    //{ 小众乐游 by arthur
//    'minorityTour.html' => 'minorityTour/index',
//    'minorityTour/minorityTourCategory_<cid:\d+>.html' => 'minorityTour/index',
//    'minorityTour/minorityTourDetail_<pid:\d+>.html' => 'minorityTour/minorityTourDetail',
//    'minorityTour/minorityTourArea_<areaid:\d+>.html' => 'minorityTour/minorityTourArea',
    //}
    //{ 欧洲旅游
//    'europe' => 'busTour/index',
//    'europe/bus-tour' => 'busTour/map',
    //}

    //{ sitemap by arthur
//    'sitemap.xml' => 'siteMap/index',
//    'sitemap/<c:\w+>/<p:\d+>.xml' => 'siteMap/list',
//    'sitemap/<c:\w+>.xml' => 'siteMap/list',
    //}
);
?>
