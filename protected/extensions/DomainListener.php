<?php
class DomainListener{
    // check whether this domain should be dealed or not
    public static function isAffiliateSiteRequest(){
        static $isAffiliateSiteRequest = null;
        if(!$isAffiliateSiteRequest){
            $isAffiliateSiteRequest = self::getIsAffiliateSiteRequest();
        }
        return $isAffiliateSiteRequest;
    }

    public static function getIsAffiliateSiteRequest()
    {
        //get affiliate domain.
        $domain = self::getCurrentDomain();
        $affiliate_domain = array_reverse(array_filter(explode('.', $domain)));
        $affiliate_domain = trim($affiliate_domain[count($affiliate_domain) - 1]);
        $is_affiliate = false;
        $white_page = array( 'www', 'cn', 'stg', 'qa', 'admin');
        if (!empty($affiliate_domain) && !in_array($affiliate_domain, $white_page)) {
            $cache = Yii::app()->cache;
            if (isset($cache)) {
            if (isset($cache[$affiliate_domain])) {
                return $cache[$affiliate_domain] === 'yes';
            }
            //check affiliate domain.
            $affiliate = Affiliate::model()->findByAttributes(array('subdomain' => $affiliate_domain));
            $is_affiliate = !!$affiliate;
            $cache->set($affiliate_domain, $is_affiliate ? 'yes' : 'no', 60);
            }
        }
        return $is_affiliate;
    }

    /**
     * @todo when the request comes from a invalid sud-domain, return an 404 error
     * @name send404Error
     */
    public static function send404Error(){
        header("HTTP/1.1 404 Page Not Found");
        echo '<h1>Not Found</h1>';
        echo '<p>The requested URL '.$_SERVER['REQUEST_URI'].' was not found on this server.</p>';
        exit;
    }

    /**
     * @todo get current domain
     * @name getCurrentDomain
     */
    public static function getCurrentDomain(){
        $domain = $_SERVER['HTTP_HOST'];
        $domain = preg_replace('/:\d+/','',$domain);
        return $domain;
    }

    /**
     * @todo get the domain name that assigned to affiliates
     * @name getDomainName
     */
    public static function getDomainName(){
        if(!self::isAffiliateSiteRequest()){
            return '';
        }
        $domain = self::getCurrentDomain();
        $domainParts = explode('.',$domain);
        return $domainParts[0];
    }

    public static function getRequestPageCode(){
        $request_uri = secure_string($_SERVER['REQUEST_URI']);
        $request_uri = preg_replace('/(\?.*)?/','',$request_uri);
        $_routeString = Yii::app()->params['languageId'] < 3 ? 'tours' : 'list';
        if(!preg_match('/^\/'.$_routeString.'\/[^\/]+/',$request_uri)){
            return '';
        }
        $request_uri = trim($request_uri,'/ ');
        $uri_parts = explode('/',$request_uri);
        return $uri_parts[1];
    }

    public static function getMainSiteHost(){
        static $mainSiteHost = null;
        if(!$mainSiteHost){
            if(isset(Yii::app()->params['defaultDomain'])){
                $mainSiteHost = Yii::app()->params['defaultDomain'];
            } else {
                $_host = $_SERVER['HTTP_HOST'];
                $_segs = explode('.', $_host);
                switch(count($_segs)){
                    case 1:
                    case 2:
                        $mainSiteHost = $_host;
                        break;
                    case 3:
                        $_segs[0] = 'www';
                        $mainSiteHost = implode('.', $_segs);
                        break;
                    default:
                        array_shift($_segs);
                        $mainSiteHost = implode('.', $_segs);
                }
            }
        }
        return $mainSiteHost;
    }
}

?>