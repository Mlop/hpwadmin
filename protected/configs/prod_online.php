<?php
define('WEBEEZ_LIB' , dirname(__FILE__) . '/../../../yiimodel');
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'charset'=>'UTF-8',
    'preload'=>array(),
    'import'=>array('application.controllers.BaseController','webeez.classes.ChineseTrans','webeez.extensions.DomainListener'),
    'defaultController'=>'site',
    'modules'=>array(),
    'components'=>array(
        'sphinx' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;port=9306',
        ),
        'segment' => array('class' => 'webeez.classes.Segment', 'server'=>'127.0.0.1:9805'),
        'mobileDetect' => array(
            'class' => 'webeez.extensions.MobileDetect'
        ),
        'mailer' => array(
            'class' => 'webeez.extensions.phpmailer.EMailer',
            'defaultSender' => 'ses',
            'defaultFromMail' => 'webmaster@toursforfun.com',
            'defaultFromName' => '途风旅游网客服部',
            'defaultReply' => 'service@toursforfun.com',
        ),
        'Txt2Img' => array(
            'class' => 'application.components.Txt2Img'
        ),
        'QQSDK' => array(
            'app_id' => '100299904',
            'app_key' => '62978a8603506f6cae0c07408054f6f9',
            'scope' => 'get_user_info,add_album,add_t,add_pic_t,add_idol',
            'class' => 'application.components.QQSDK',
            'callback' => 'Account/SnsoAuthCallback'
        ),
        'SinaSDK' => array(
            'client_id' => '1495418171',
            'client_secret' => '4626661ae5418f85317ba1cb030ea107',
            'class' => 'application.components.SinaSDK',
            'callback' => 'Account/SnsoAuthCallback'
        ),
        /** commented by Tuzki 2014-4-3
        'Wordpress' => array(
            'class' => 'application.components.Wordpress',
            'word_press_url' => 'http://blog.toursforfun.com/'
        ),
         */
        'errorHandler'=>array('errorAction'=>'site/error'),
        'urlManager'=>array(
            'class'=>'webeez.classes.WebeezUrlManager',
            'urlFormat'=>'path',
            'caseSensitive'=>true,
            'showScriptName'=>false,
            'rules' => include('route.php'),
            'cdn' => array(
                'qiniu' => array(
                    'http' => 'http://dn-toursforfun.qbox.me',
                    'https' => 'https://dn-toursforfun.qbox.me',
                ),
            ),
            'secureController' => array(
                'affiliateCenter' => '*',
                'affiliateCode' =>  '*',
                'affiliateBanner'=> '*',
                'account'=>array('login','register','forgottenPassword','captcha')
            ),
        ),
        'authManager'=>array('class'=>'webeez.classes.WebeezAuthManager'),
        'session' => array ('class' => 'webeez.classes.WebeezRedisSession'),
        'numberFormatter'=>array( 'class'=>'webeez.classes.WebeezNumberFormatter'),
        'currencyFD' => array('class' => 'webeez.classes.WebeezCurrencyFD'),
        'user'=>array(
            'class'=>'webeez.classes.WebeezCustomer',
            'returnUrl'=>array('MyAccount/index'),
            'loginUrl'=>array('Account/login'),
            'allowAutoLogin'=>true,
        ),
        'smsSender'=>array('class'=>'webeez.classes.SMSSender'),
        'clientScript'=>array('class'=>'webeez.classes.WebeezClientScript','scriptMap' => array(
            'jquery.js' => '/js/jquery.js',
            'jquery.min.js' => false,
        )),
        'cache' => array(
            'class' => 'system.caching.CApcCache',
            'keyPrefix' => 'newtff',
        ),
        'insuranceAPI'=>array(
            'class' => 'webeez.classes.InsuranceAPI',
        ),
		'myCart' => array('class' => 'webeez.classes.myProcess.MyCart'),
		'myOrder' => array('class' => 'webeez.classes.myProcess.MyOrder'),
		'myCalculator' => array(
			'class' => 'webeez.classes.myProcess.MyCalculator',
			'plugin' => array(
				//'webeez.classes.myProcess.plugin.ICBC',
				//'webeez.classes.myProcess.plugin.Point',
			),
		),
        'session_cooperator' => array ('class' => 'webeez.classes.WebeezRedisSession','sessionName'=>'COOPERATOR'),
        'user_cooperator'=>array('class'=>'CooperatorWebUser','returnUrl'=>array('cooperate/index'),'loginUrl'=>array('cooperate/login')),
        'rackspaceConnect' => array(
            'class' => 'webeez.extensions.rackspace.RackspaceConnect',
            // following params will overwrite in template
            'username' => 'tours4fun',
            'apiKey' => 'd307a65e0320ebc59af6d98797163bbe',
            'serviceName' => 'cloudFiles',
            'region' => 'DFW',
            'imageContainerName' => 'test',
            'cssContainerName' => 'test',
            'debug' => true,
        ),
        'viewRenderer' => array(
            'class' => 'webeez.extensions.ETwigViewRenderer',
            'twigPathAlias' => 'webeez.vendors.Twig',
            'functions' => array(
                'strimwidth' => 'mb_strimwidth',
                't' => 'Yii::t',
                'md5' => 'md5'
            ),
        ),
        'queue' => array(
            'class' => 'webeez.extensions.T4fBeanstalkdConnection',
            'servers' => array(
                array('host' => '127.0.0.1', 'port' => 11300),
            ),
        ),
        'uid' => array(
            'class' => 'webeez.extensions.T4fIdGenerator',
            'server' => array('host' => '127.0.0.1', 'port' => 9806),
        ),
    ),
    'params' => array(
        'devEmail'=>'webmaster@toursforfun.com',
        'storePhone'=>'1-866-933-7368 (US&Canada), 1-626-389-8668 (International)',
        'contactTime'=>'9:00am~5:00pm, Monday~Sunday, Pacific Standard Time',
        'reviewsEmail'=>'review@tours4fun.com',
        'mainImagesabsuPath' => 'images/',
        //variables below will override by template.php
        'geoIpFile' => '/opt/geo_ip/GeoIP2-City.mmdb',
        'storeId'=>4,
        'languageId'=>3,
        'cookieDomain'=>'.toursforfun.com',
        'catalogUrl'=>'http://yii.toursforfun.com',
        'catalogSecureUrl'=>'https://yii.toursforfun.com',
        'providerUrl'=>'http://yiipa.toursforfun.com',
        'qiniuCdnUrl'=> IS_PROD_SITE ? "http://dn-toursforfun.qbox.me" : (IS_QA_SITE ? "http://dn-toursforfunqa.qbox.me" : ""),
        'qiniuCdnSSLUrl'=> IS_PROD_SITE ? "https://dn-toursforfun.qbox.me" : (IS_QA_SITE ? "https://dn-toursforfunqa.qbox.me" : ""),
        'domain'=>'.toursforfun.com',
        'mSiteUrl' => IS_PROD_SITE ? 'http://m.toursforfun.com' : 'http://qa-m.toursforfun.com'
    ),
);
