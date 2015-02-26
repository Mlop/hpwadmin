<meta property="qc:admins" content="240604573664666375" />
<meta property="wb:webmaster" content="28c3d0536bd4ab9d">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="<?php echo isset($this->ieDocMode) && $this->ieDocMode != '' ? $this->ieDocMode : 'IE=edge' ?>,chrome=1">
<meta name="renderer" content="webkit">
<script type="text/javascript">
var CLIENTSTATUS = {
	"login":<?php echo Yii::app()->user->isGuest?'false':'true'; ?>,
	"lang":"<?php echo LANGUAGE_ID != 'tw' ? 'cn' :'tw' ; ?>","serverTime":"<?php echo time(); ?>",
	"uid":"<?php echo !Yii::app()->user->isGuest?Yii::app()->user->id:0; ?>",
	"name":<?php echo CJSON::encode(Yii::app()->user->name) ?>,
	"cookieDomain":"<?php echo Yii::app()->params['cookieDomain']; ?>",
    "level" : "<?php echo Yii::app()->user->isGuest ? '' : Yii::app()->user->level; ?>",
	<?php if(isset(Yii::app()->user->email)){ ?> "email":<?php echo CJSON::encode(Yii::app()->user->email) ?>, <?php } ?>
	<?php if(isset(Yii::app()->user->last_login)){ ?> "last_login":<?php echo CJSON::encode(Yii::app()->user->last_login) ?>,<?php } ?>
	"version" : "0.1"
};
</script>
<title><?php echo $this->pageTitle !=''? $this->pageTitle :'途风旅游网（携程旗下）- 美国,加拿大,欧洲,澳洲出境旅游旅行团服务专家' ?></title>
<?php if($this->pageDesc !=' '){ ?>
<meta name="description" content="<?php echo $this->pageDesc != '' ? CHtml::encode($this->pageDesc) : '途风旅游网是一家专业提供海外目的地旅游的华人旅行社，涵盖美国、加拿大、欧洲、澳大利亚、新西兰等5000多条出国旅游线路，同时提供邮轮、旅游签证、星级酒店、机场接送、景点门票等各类出境游服务。400 - 635 - 6555'?>" />
<?php } ?>
<?php if($this->pageKey !=' '){ ?>
<meta name="keywords" content="<?php echo $this->pageKey != '' ? CHtml::encode($this->pageKey) :'美国旅游,加拿大旅游,欧洲旅游,澳洲旅游,华人旅行社,出境游,出国旅游'?>" />
<?php } ?>
<meta name="reply-to" content="service@toursforfun.com">
<?php


if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
	echo '<meta name="robots" content="noindex,follow">';
}else{
	echo '<meta name="robots" content="index, follow">';
}
$requestPath = Yii::app()->request->getRequestUri();
$requestPath = preg_replace('/(ref|utm_source|utm_term|utm_medium|utm_campaign|clk_source|clk_term|cPath|clk|language)=[\w\-]*&?/', '',
                            $requestPath);
$requestPath = rtrim($requestPath, '&?');
if (!(stristr($requestPath, '.php') || stristr($requestPath, '.html') || stristr(substr(strrev($requestPath), 0, 1), '/'))) {
    $canonical = Yii::app()->request->getHostInfo() . $requestPath . '/';
} else {
    $canonical = Yii::app()->request->getHostInfo() . $requestPath;
}
?>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
<link rel="canonical" href="<?php echo secure_array($canonical);?>">
<?php
$themes = array();
if(FESTIVAL_THEME1_ENABLE && FESTIVAL_THEME1_START<time() && FESTIVAL_THEME1_END>time()) $themes[FESTIVAL_THEME1_PRIORITY] = array(FESTIVAL_THEME1_LOGO,FESTIVAL_THEME1_IMG);
if(FESTIVAL_THEME2_ENABLE && FESTIVAL_THEME2_START<time() && FESTIVAL_THEME2_END>time()) $themes[FESTIVAL_THEME2_PRIORITY] = array(FESTIVAL_THEME2_LOGO,FESTIVAL_THEME2_IMG);
if(FESTIVAL_THEME3_ENABLE && FESTIVAL_THEME3_START<time() && FESTIVAL_THEME3_END>time()) $themes[FESTIVAL_THEME3_PRIORITY] = array(FESTIVAL_THEME3_LOGO,FESTIVAL_THEME3_IMG);
if(FESTIVAL_THEME4_ENABLE && FESTIVAL_THEME4_START<time() && FESTIVAL_THEME4_END>time()) $themes[FESTIVAL_THEME4_PRIORITY] = array(FESTIVAL_THEME4_LOGO,FESTIVAL_THEME4_IMG);
krsort($themes);
$themes = array_pop($themes);
if(is_array($themes)&& $themes[1]!='' && $themes[0]!='' ){
    echo '<style type="text/css">';
    echo '.header-wrap{background:url(' . Yii::app()->staticUrl($themes[0]) . ') no-repeat center top #fff;}';
    echo '.w-1000 .header-wrap{background:url(' . Yii::app()->staticUrl($themes[1]) . ') no-repeat center top #fff;}';
    echo '</style>';
}
?>
<!-- SER:--><?php //echo Yii::app()->params->serverId ?>
