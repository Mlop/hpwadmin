<?php
/**
 * This component is used for front-end  
 * we can use createUrl to generate a full url
 * @author vincent.mi@toursforfun.com
 */
class WebeezUrlManager extends CUrlManager{

	public $secureHost = '';
	public $commonHost = '';
    public $secureController = array( 'affiliateCenter' => '*');
    public $cdn = array();

    function __construct()
    {
        parent::init();
        $this->processRules();
    }

	/**
	 * override CController::createUrl
	 * @see {CController::createUrl}
	 * @param string $route     
	 * @param array $params
	 * @param booean|string $useSSL
	 * @author vincent.mi@toursforfun.com
	 */
	public function createUrl($route,$params=array(),$useSSL=false)
	{
		if(!is_bool($useSSL)){
			$useSSL = trim(strtolower($useSSL));
			if($useSSL == 'ssl' || $useSSL == 'true' || $useSSL == '1' || $useSSL == 'https'){
				$useSSL = true ;
			} else {
				$useSSL = $this->checkSSLRoute($route);
            }
		}
		if($useSSL == true){
			$host = ($this->secureHost == '')? Yii::app()->request->getHostInfo('https'):$this->secureHost;
		}else{
			$host = ($this->commonHost == '')? Yii::app()->request->getHostInfo('http'):$this->commonHost;
		}
		$url = $host.parent::createUrl($route , (array)$params , '&' ) ;
        if (preg_match('/\/[a-zA-Z-]+$/' , $url)) {
            $url = $url. '/';
        }
        return $url;
	}

    /**
     * Get URL with CDN prefixes.
     *
     * @param string $url URL
     * @param array $options Options for specified CDN.
     * @return string
     *
     * @example
     *
     *      Yii::app()->staticUrl(
     *          '/img/example.jpg',
     *          array(
     *              'provider' => 'qiniu',
     *              'mode' => '2', // optional
     *              'width' => '200',
     *              'height' => '200',
     *              'quality' => '85', // optional
     *              'format' => 'jpg', // optional
     *          )
     *      );
     */
    public function staticUrl($url, $options = array())
    {
        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        $provider = isset($options['provider']) ? $options['provider'] : 'default';

        $url = $this->completeUrl($url, $provider);

        if ($provider !== 'default') {
            $method = $provider . 'Suffix';
            if (!method_exists($this, $method)) {
                throw new Exception('There is no provider `' . $provider . '`');
            }
            $url .= $this->$method($options);
        }

        return $url;
    }

    /**
     * Complete URL with CDN prefixes.
     *
     * @param string $url URL.
     * @param string $provider The CDN provider.
     * @return string
     */
    private function completeUrl($url, $provider = 'default')
    {
        if ($provider == 'default') {
            $prefix = '';
            if (Yii::app()->getRequest()->getIsSecureConnection()) {
                if (isset(Yii::app()->params['cdnSSLUrl']) && Yii::app()->params['cdnSSLUrl']) {
                    $prefix = Yii::app()->params['cdnSSLUrl'];
                }
            } else {
                if (isset(Yii::app()->params['cdnUrl']) && Yii::app()->params['cdnUrl']) {
                    $prefix = Yii::app()->params['cdnUrl'];
                }
            }
            $url = $prefix . $url;
        } else {
            if (isset($this->cdn[$provider]) && $domain = $this->cdn[$provider]) {
                $prefix = '';
                if (Yii::app()->getRequest()->getIsSecureConnection()) {
                    if (isset($domain['https']) && $domain['https']) {
                        $prefix = $domain['https'];
                    }
                } else {
                    if (isset($domain['http']) && $domain['http']) {
                        $prefix = $domain['http'];
                    }
                }
                $url = $prefix . $url;
            }
        }
        return $url;
    }

    /**
     * Build suffix with qiniu API.
     *
     * @See http://developer.qiniu.com/docs/v6/api/reference/fop/image/imageview2.html
     *
     * @param array $options Building options.
     * @return string
     */
    private function qiniuSuffix(array $options)
    {
        // imageView2/2/w/200/h/200
        // imageView2/<mode>/w/<Width>/h/<Height>/q/<Quality>/format/<Format>
        if (!isset($options['width']) && !isset($options['height'])) {
            throw new Exception('See http://developer.qiniu.com/docs/v6/api/reference/fop/image/imageview2.html');
        }

        $suffix = '?imageView2/';
        $options['mode'] = isset($options['mode']) ? $options['mode'] : '2'; // default 2 for PC thumbnail.
        if (!preg_match('/^\d+$/', $options['mode'])) {
            throw new Exception('Invalid option `mode`');
        }
        $suffix .= $options['mode'];

        if (isset($options['width']) && !preg_match('/^\d+$/', $options['width'])) {
            throw new Exception('Invalid option `width`');
        }
        if (isset($options['height']) && !preg_match('/^\d+$/', $options['height'])) {
            throw new Exception('Invalid option `height`');
        }
        if (isset($options['quality']) && !preg_match('/^\d+$/', $options['quality'])) {
            throw new Exception('Invalid option `quality`');
        }
        if (isset($options['format']) && !preg_match('/^(jpg|gif|png)$/i', $options['format'])) {
            throw new Exception('Invalid option `format`');
        }

        if (isset($options['width']) && $options['width']) {
            $suffix .= '/w/' . $options['width'];
        }
        if (isset($options['height']) && $options['height']) {
            $suffix .= '/h/' . $options['height'];
        }
        if (isset($options['quality']) && $options['quality']) {
            $suffix .= '/q/' . $options['quality'];
        }
        if (isset($options['format']) && $options['format']) {
            $suffix .= '/format/' . $options['format'];
        }

        return $suffix;
    }

    /**
     * @description checkout route
     * @param string
     * @return bool
    */
    public  function checkSSLRoute($route)
    {
        if (empty($this->secureController))
            return false;
        else if($this->secureController === '*')
            return true;
        $controller_info = explode('/', $route);
        $_controller_name = isset($controller_info[0]) ? $controller_info[0] : '';
        $_action_name = isset($controller_info[1]) ? $controller_info[1] : '';
        $secure_route = isset($this->secureController[$_controller_name]) ? $this->secureController[$_controller_name] : '';
        if ($secure_route === '*') {
            return true;
        } else if (is_array($secure_route) && in_array($_action_name, $secure_route)){
            return true;
        } else {
            return false ;
        }
    }
}
