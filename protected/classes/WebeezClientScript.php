<?php

/**
 * Extends CClientScript.
 */
class WebeezClientScript extends  CClientScript {

    /**
     * JS conditions.
     */
    private $scriptConditions = array();

    /**
     * CSS conditions.
     */
    private $cssConditions = array();

	private $html = array();
	/**
	 * insert some html code before </body>
	 * @param unknown $html
	 * @return WebeezClientScript
	 */
	public function insertHTML($id , $html)
	{
		if(!isset($this->html[$id])){
			$this->html[$id] = $html ;
		}
		$params['html'] = $html;
		$this->recordCachingAction('WebeezClientScript','insertHTML',$params);
		return $this;
	}
	
	public function isHTMLRegistered($id){
		return isset($this->html[$id]);
	}
	/**
	 * (non-PHPdoc)
	 * @see CClientScript::render()
	 */
	public function render(&$output){
		$fullPage=0;		
		$output=preg_replace('/(<\\/body\s*>)/is','<###end###>$1',$output,1,$fullPage);
		$html='';
		foreach($this->html as $htmlItem){
			$html.= $htmlItem."\n";
		}
				
		if($fullPage)
			$output=str_replace('<###end###>',$html,$output);
		else
			$output=$output.$html;
		
		parent::render($output);

        foreach ($this->scriptConditions as $url => $condition) {
            if (!isset($condition['on']) || !$condition['on']) {
                continue;
            }
            if (!preg_match('`<script.+?src="' . $url . '".*?></script>`i', $output, $matches)) {
                continue;
            }
            $this->wrapCondition($output, $condition['on'], $matches[0]);
        }

        foreach ($this->cssConditions as $url => $condition) {
            if (!isset($condition['on']) || !$condition['on']) {
                continue;
            }
            if (!preg_match('`<link.+?href="' . $url . '".+?>`i', $output, $matches)) {
                continue;
            }
            $this->wrapCondition($output, $condition['on'], $matches[0]);
        }
	}

    /**
     * Wrap comment around statement.
     *
     * @param string $output
     * @param string $condition
     * @param string $target
     * @return void
     */
    private function wrapCondition(&$output, $condition, $target)
    {
        $output = preg_replace('`' . $target . '`i',
            sprintf('<!--[if %s]>%s<![endif]-->', $condition, $target),
            $output);
    }

    /**
     * @inheritdoc
     */
    public function registerCssFile($url, $media = '', array $conditions = array())
    {
        // $url = Yii::app()->staticUrl($url);

        if (!empty($conditions))
            $this->cssConditions[$url] = $conditions;

        return parent::registerCssFile($url, $media, $conditions);
    }

    /**
     *  use seaJS concat load js file from CDN
     *
     * @param $files 需要concat的JS
     * @param $params  array(
     * "config" => "script/config.js",  //seaJS配置文件
     * "reset" => true,  // 是否reset之前注册的脚本
     * "route" => "script/concat_tw", //拼接JS的方法路由
     * "cdn" => "http://qiniu" //手动指定cdn
     * "id" => "pagejs" //指定registerScriptFile参数id
     * );
     * @return bool
     */
    public function registerSeaJsFile($files,$params=array())
    {
        $params = (is_array($params)) ? $params : array();
        $config = isset($params['config']) ? $params['config'] : "script/config.js";
        if (is_array($files) && $files && file_exists($config)) {
            $reset = isset($params['reset']) ? $params['reset'] : true;
            $id = isset($params['id']) ? $params['id'] : "pagejs";
            $route = isset($params['route']) ? $params['route'] : "";
            $cdn = isset($params['cdn']) ? $params['cdn'] : "";
            if (!$route) {
                $route = (LANGUAGE_ID == 'tw') ? "script/concat_tw" : "script/concat_sc";
            }
            if (!$cdn) {
                if (Yii::app()->request->isSecureConnection) {
//                    $cdn = Yii::app()->urlManager->cdn["qiniu"]["https"];
                    $cdn =Yii::app()->params["qiniuCdnSSLUrl"];

                } else {
//                    $cdn = Yii::app()->urlManager->cdn["qiniu"]["http"];
                    $cdn =Yii::app()->params["qiniuCdnUrl"];
                }
            }
            $route = $cdn ."/" .$route;
            if ($reset) {
                $this->reset();
            }
            $files = json_encode($files);
            $md5 = Yii::app()->cache->get("seaJS_config_hash_key");
            if(!$md5){
                $md5 = md5(uniqid(true));
                $md5 = substr($md5, 8, 16);
                Yii::app()->cache->set("seaJS_config_hash_key",$md5,60*20);
            }
            if (defined("FRONTEMD_VER_REFRESH_NO") && FRONTEMD_VER_REFRESH_NO) {
                $md5 = FRONTEMD_VER_REFRESH_NO . $md5;
            }
            $this->registerScriptFile($route . '~sea.js&seajs-combo.js&seajs-preload.js&seajs-css.js&config.js=' .$md5);
            $this->registerScript($id, 'seajs.use(' . $files . ');', CClientScript::POS_HEAD);
            return true;
        }
    }


    /**
     * @inheritdoc
     */
    public function registerScriptFile($url, $position = self::POS_HEAD, array $conditions = array())
    {
        // $url = Yii::app()->staticUrl($url);

        if (!empty($conditions))
            $this->scriptConditions[$url] = $conditions;

        return parent::registerScriptFile($url, $position, $conditions);
    }

    /**
     * @inheritdoc
     */
    public function isCssFileRegistered($url)
    {
        return parent::isCssFileRegistered($url)
            || parent::isCssFileRegistered(Yii::app()->staticUrl($url));
    }

    /**
     * @inheritdoc
     */
    public function isScriptFileRegistered($url, $position=self::POS_HEAD)
    {
        return parent::isScriptFileRegistered($url, $position)
            || parent::isScriptFileRegistered(Yii::app()->staticUrl($url), $position);
    }
}
