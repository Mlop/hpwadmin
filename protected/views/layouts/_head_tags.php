<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="misapplication-tap-highlight" content="no" />
<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<title><?php echo $this->pageTitle !=''? $this->pageTitle : "收账管理系统";?></title>
<?php Yii::app()->clientScript->registerCssFile('/js/bootstrap/css/bootstrap.min.css');?>
<?php Yii::app()->clientScript->registerCssFile('/js/bootstrap/css/bootstrap-theme.min.css');?>
<?php Yii::app()->clientScript->registerCssFile('/js/jQuery/jquery.mobile-1.4.5/jquery.mobile-1.4.5.css');?>
<style>
    .main{
        height:100px;
    }
    .custom-corners .ui-bar{
        -webkit-border-top-left-radius: inherit;
        border-top-left-radius: inherit;
        -webkit-border-top-right-radius: inherit;
        border-top-right-radius: inherit;
    }
    .custom-corners .ui-body{
        -webkit-border-bottom-left-radius: inherit;
        border-bottom-left-radius: inherit;
        -webkit-border-bottom-right-radius: inherit;
        border-bottom-right-radius: inherit;
    }
    .panel-title-thisyear span:before{
        content: '今年：';
    }
    .panel-title-lastyear span:before{
        content: '往年：';
    }
</style>








