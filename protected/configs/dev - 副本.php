<?php
//error_reporting('E_ALL & ~E_NOTICE');
//define('WEBEEZ_LIB' , 'D:/work/www/yii/yiimodel/branches/dev');
//define('WEBEEZ_LIB', dirname(__FILE__) . '/../../../yiimodel');
define('WEBEEZ_MODEL_LIB', dirname(__FILE__) . '/../models');
define('WEBEEZ_LIB', dirname(__FILE__) . '/../../');
define('YII_PATH',WEBEEZ_LIB.'framework'.DIRECTORY_SEPARATOR);
/**
 * Share models from SA
 */

// Add model folder to include path.
set_include_path(get_include_path().PATH_SEPARATOR.WEBEEZ_MODEL_LIB);

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'charset' => 'UTF-8',
    'preload' => array(),
    'import' => array(
        'application.controllers.BaseController',
        'webeez.classes.ChineseTrans',
        'webeez.extensions.DomainListener'
    ),
    'defaultController' => 'site',
    'modules' => array(),
    'components' => array(
        'currencyFD' => array('class' => 'webeez.classes.WebeezCurrencyFD'),
        'sphinx' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'mysql:host=db.tff.com;port=9306',
            'emulatePrepare' => true,
            'charset' => 'utf8',
        ),
        'segment' => array('class' => 'webeez.classes.Segment', 'server'=>'127.0.0.1:9805'),
        'mobileDetect' => array(
            'class' => 'webeez.extensions.MobileDetect'
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
        'mailer' => array(
            'Password' => 'snake==>',
            'Username' => 'tours@126.com',
            'SMTPAuth' => 'true',
            'Port' => '25',
            'Host' => 'smtp.126.com',
            'class' => 'webeez.extensions.phpmailer.EMailer',
            'defaultSender' => 'smtp',
            //'debugMailAddress'=>'281956350@qq.com',
            //'defaultFromMail'=>'webmaster@tours4fun.com',
            'defaultFromName' => '途风网客服部'
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
        'Wordpress' => array(
            'class' => 'application.components.Wordpress',
            'word_press_url' => 'http://blog.toursforfun.com/'
        ),
        'db' => array(
            'class' => 'webeez.extensions.DbConnection', //CDbConnection
            'emulatePrepare' => true,
            'charset' => 'utf8',
//            250配置
//            'connectionString' => 'mysql:host=192.168.0.250;dbname=tff_2014_06_24',
//            'username' => 'root',
//            'password' => 'tufeng1801',
            'connectionString' => 'mysql:host=localhost;dbname=transfer',
            'username' => 'root',
            'password' => 'root'
        ),
//        'queue' => array(
//            'class' => 'webeez.extensions.T4fBeanstalkdConnection',
//            'servers' => array(
//                array(
//                    'host' => '192.168.0.141',
//                    'port' => '11300',
//                ),
//                array(
//                    'host' => '192.168.0.142',
//                    'port' => '11300',
//                )
//            ),
//        ),
        'cache'=>array(
            'class' => 'system.caching.CApcCache',
            'keyPrefix' => 'newtff',
        ),
//        'cache'=>array(
//            'class'=>'system.caching.CMemCache',
//            'keyPrefix' => 'daniel',
//            'useMemcached' => true,
//            'servers'=>array(
//                array(
//                    'host'=>'192.168.0.250',
//                    'port'=>11211,
//                ),
//            ),
//        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CProfileLogRoute',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
//        'redis' => array(
//            'class' => 'webeez.extensions.T4fRedis',
//            'servers' => array(
//                'scheme'   => 'tcp',
//                'host'     => '192.168.0.250',
//                'port'     => 6379,
//                'database' => 15
//            )
//        ),

        'errorHandler' => array('errorAction' => 'site/error'),
        'urlManager' => array(
            'class' => 'webeez.classes.WebeezUrlManager',
            'urlFormat' => 'path',
            'caseSensitive' => true,
            'showScriptName' => false,
            'rules' => include('route.php'),
            'secureHost' => 'http://www.tff-vera.com',
            'commonHost' => 'http://www.tff-vera.com',
            'cdn' => array(
                // provider => domain
                //'default' => 'xxx.rackcdn.com', // Note: just domain here, no schema
                'qiniu' => array(
                    'http' => 'http://toursforfun.qiniudn.com',
                    'https' => 'https://toursforfun.qiniudn.com',
                ),
            ),
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
        'authManager' => array('class' => 'webeez.classes.WebeezAuthManager'),
        'session' => array('class' => 'webeez.classes.WebeezSession', 'autoGC' => false, 'sessionName' => 'DEV_SESSID'),
        'numberFormatter' => array('class' => 'webeez.classes.WebeezNumberFormatter'),
        'user' => array(
            'class' => 'webeez.classes.WebeezCustomer',
            'returnUrl' => array('MyAccount/index'),
            'loginUrl' => array('Account/login'),
            'allowAutoLogin' => true
        ),
        'smsSender' => array('class' => 'webeez.classes.SMSSender'),
        'clientScript' => array(
            'class' => 'webeez.classes.WebeezClientScript',
            'scriptMap' => array('jquery.js' => '/js/jquery.js', 'jquery.min.js' => false)
        ),
        'insuranceAPI' => array(
            'class' => 'webeez.classes.InsuranceAPI'
        ),
        'session_cooperator' => array('class' => 'webeez.classes.WebeezSession', 'sessionName' => 'COOPERATOR'),
        'user_cooperator' => array(
            'class' => 'CooperatorWebUser',
            'returnUrl' => array('cooperate/index'),
            'loginUrl' => array('cooperate/login')
        ),
    ),
    'params' => array(
        'devEmail' => 'robert.zeng@tours.com',
        'storePhone' => '1-866-933-7368 (US&Canada), 1-626-389-8668 (International)',
        'contactTime' => '9:00am~5:00pm, Monday~Sunday, Pacific Standard Time',
        'reviewsEmail' => 'review@tours4fun.com',
        //variables below will override by template.php
        'mainImagesabsuPath' => '/vagrant/test/',
//        'mainImagesabsuPath' => '/vagrant/tuorsfun/dev/test/',
//        'mainImagesabsuPath' => '/images/',
//        'cdnUrl' => 'http://bfc6069c43f7ffbc5dba-0502af2ee568fe969e1c3ea7c42e34f6.r90.cf1.rackcdn.com',
        'cdnSSLUrl' =>  'https://cdn.tff.com',
        'cdnCNAMEUrl' => 'http://images.toursforfun.com',
//        'geoIpFile' => '/opt/geo_ip/GeoIP2-City.mmdb',
        'geoIpFile' => '\GeoIP2-City.mmdb',
        'storeId' => 4,
        'languageId' => 3,
        'cookieDomain' => '.tff-vera.com',
        'catalogUrl' => 'http://www.tff-vera.com',
        'catalogSecureUrl' => 'http://www.tff-vera.com',
        'providerUrl' => 'http://provider.tours4fun.com',
        'defaultDomain' => 'www.tff-vera.com',
        'domain' => '.tff-vera.com',
        'serverId'=>0,
    ),
);
