<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <?php require_once('_head_tags.php'); ?>
</head>
<body class="<?php echo $this->body_class ?>">
<?php
if(strtotime(SHOW_NOTE_START_DATE)<time() && time()<strtotime(SHOW_NOTE_END_DATE)){
    if (strtolower(Yii::app()->getController()->getAction()->controller->id) == 'site' && strtolower(Yii::app()->getController()->getAction()->controller->action->id) == 'index'){
?>
<script>
(function(fn) {
    if (window.seajs) {
        seajs.use(["DD_belatedPNG", "jquery", "jquery.cookie"], fn);
    } else {
        fn();
    }
})(function() {
    $(function() {
        var tip = $('#website-tips');
        var close = $('#close-website-tips');
        var ck = $.cookie('tff_website-tips');
        if (!ck || ck == '') {
            tip.show();
        }
        close.click(function() {
            tip.slideUp();
            $.cookie('tff_website-tips', 'off', {
                expires: 30
            });
        });
    });
    if (window.DD_belatedPNG) {
        DD_belatedPNG.fix("#close-website-tips");
    }
});
</script>
<div id="website-tips" class="pngFix" style="display: none;">
    <div class="website-tips pngFix">
        <b><?php echo SHOW_NOTE_CONTENT;?></b><a id="close-website-tips" href="javascript:;">我知道了</a>
    </div>
</div>
<?php
    }
}
?>
<?php if ($showTopBanner){ ?>
<div class="home-top-banner-holder" id="home-top-banner-holder">
<!--    --><?php //$this->widget('application.widgets.BannerWidget', array('group'=>'TFF Home Page Top Banner 1200x100', 'slider_type'=>'image', 'cssClass'=>'small')) ?>
    <!--    {# 顶部广告 #}-->
<!--    --><?php //$this->widget('application.widgets.BannerWidget', array('group'=>'TFF Home Page Slide Down Banner 1200x450', 'slider_type'=>'home_slide_down', 'cssClass'=>'big')) ?>
    <!--    {# 顶部下滑广告 #}-->
</div>
<?php } ?>
<?php //$this->Widget('application.widgets.CustomerStatusBarWidget') ?>
<?php //$this->widget('application.widgets.mainSearchWidget'); ?>
<?php //$this->widget('application.widgets.MenuWidget'); ?>
<!--   {#导航条#}-->
<?php echo $content; ?>
<?php require_once('_footer.php'); ?>