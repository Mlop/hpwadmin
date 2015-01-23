<?php

$config['components']['db'] = array(
    'class' => 'webeez.extensions.T4fDbConnection',
    'emulatePrepare' => true,
    'connectionString' => 'mysql:host=@@DB_SERVER@@;dbname=@@DB_DATABASE@@;port=@@DB_PORT@@',
    'username' => '@@DB_SERVER_USERNAME@@',
    'password' => '@@DB_SERVER_PASSWORD@@',
    'charset' => 'utf8',
    'schemaCachingDuration' => 14400, // cache for 4 hours
    'slave' => array(
        'emulatePrepare' => true,
        'connectionString' => 'mysql:host=@@DB_SERVER_SLAVE_0@@;dbname=@@DB_DATABASE_SLAVE_0@@;port=@@DB_PORT_SLAVE_0@@',
        'username' => '@@DB_SERVER_USERNAME_SLAVE_0@@',
        'password' => '@@DB_SERVER_PASSWORD_SLAVE_0@@',
        'charset' => 'utf8',
        'schemaCachingDuration' => 14400,
    ),
);

$STORE_ID = '@@STORE_ID@@';
if ($STORE_ID === '4') {
    $config['components']['cache'] = array(
        'class' => 'system.caching.CMemCache',
        'keyPrefix' => 'newtff',
        'useMemcached' => true,
        'servers' => array(
            array('host' => '@@MC_SERVER_0@@', 'port' => @@MC_PORT_0@@, 'weight' => @@MC_WEIGHT_0@@),
            array('host' => '@@MC_SERVER_1@@', 'port' => @@MC_PORT_1@@, 'weight' => @@MC_WEIGHT_1@@),
        ),
    );
    $config['components']['sphinx'] = array(
        'class' => 'system.db.CDbConnection',
        'connectionString' => 'mysql:host=@@SPHINX_SERVER@@;port=9306',
    );
    $config['components']['segment'] = array(
        'class' => 'webeez.classes.Segment',
        'server'=>'@@SEGMENT_SERVER@@:9805',
    );
    $config['components']['queue'] = array(
        'class' => 'webeez.extensions.T4fBeanstalkdConnection',
        'servers' => array(
            array('host' => '@@QUEUE_SERVER@@', 'port' => 11300),
        ),
    );
    $config['components']['uid'] = array(
        'class' => 'webeez.extensions.T4fIdGenerator',
        'server' => array('host' => '@@UID_SERVER@@', 'port' => 9806),
    );
}
/**
 * database 7 => session
 * database 25 => seckill
 */
$config['components']['redis'] = array(
    'class' => 'webeez.extensions.T4fRedis',
    'servers' => array(
        'scheme' => 'tcp',
        'host' => '@@REDIS_SERVER_0@@',
        'port' => @@REDIS_PORT_0@@,
    ),
);

$config['name'] = '@@SITE@@';

$config['language'] = '@@LANGUAGE@@';

//override for params
$config['params']['serverId'] = '@@SERVER_ID@@';
$config['params']['cdnUrl'] = '@@CDN_URL@@';
$config['params']['cdnSSLUrl'] = '@@CDN_SSL_URL@@';
$config['params']['cdnCNAMEUrl'] = 'http://images.tours4fun.com';
$config['params']['storeId'] = '@@STORE_ID@@';
$config['params']['cookieDomain'] = '@@COOKIE_DOMAIN@@';
$config['params']['mainImagesabsuPath'] = '@@IMAGES_ABSOLUTE_PATH@@';
$config['params']['catalogUrl'] = '@@CATALOG_URL@@';
$config['params']['catalogSecureUrl'] = '@@CATALOG_SECURE_URL@@';
$config['params']['providerUrl'] = '@@PROVIDER_URL@@';
$config['params']['languageId'] = $config['params']['language_id'] = '@@LANGUAGE_ID@@';
$config['params']['geoIpFile'] = '@@GEO_IP_FILE@@';

if(IS_QA_SITE === true){
	$config['components']['session']['sessionName'] = '_TFFQAID';
	$config['components']['cache']['keyPrefix'] = 'newtff_qa';
}else if($_SERVER['HTTP_HOST'] == 'dev.toursforfun.com'){
	$config['components']['session']['sessionName'] = '_TFFDEVID';
	$config['components']['cache']['keyPrefix'] = 'newtff_dev';
}else if(IS_PROD_SITE !== true) {
	$config['components']['session']['sessionName'] = 'S'.md5(__FILE__);
	$config['components']['cache']['keyPrefix'] =  'A'.md5(__FILE__);
}

// RackspaceConnect
$config['components']['rackspaceConnect'] = array(
    'class' => 'webeez.extensions.rackspace.RackspaceConnect',
    'username' => '@@RACKSPACE_USERNAME@@',
    'apiKey' => '@@RACKSPACE_API_KEY@@',
    'serviceName' => '@@RACKSPACE_SERVICE_NAME@@',
    'region' => '@@RACKSPACE_REGION@@',
    'imageContainerName' => '@@RACKSPACE_IMAGE_CONTAINER@@',
    'cssContainerName' => '@@RACKSPACE_CSS_CONTAINER@@',
    'debug' => false,
);

$config['components']['mailer']['username'] = '@@AMAZON_SES_USERNAME@@';
$config['components']['mailer']['password'] = '@@AMAZON_SES_PASSWORD@@';
