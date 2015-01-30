<div class="footer">
    <div class="foot clearfix">
        <dl>
            <dt>新手入门</dt>
            <dd>
                <a href="<?php echo $this->createUrl('serviceCenter/view', array('cid'=>55))?>" rel="nofollow">预订指南</a>
                <a href="<?php echo $this->createUrl('serviceCenter/index');?>" rel="nofollow">服务中心</a>
                <a href="<?php echo $this->createUrl('article/seoNews') ?>">旅游资讯</a>
                <a href="<?php //echo $this->createUrl('serviceCenter/view', array('cid' => ServiceCenterArticleCategory::getCidByName('升级规则'))) ?>" rel="nofollow">会员积分</a>
            </dd>
        </dl>
        <dl>
            <dt>客服服务</dt>
            <dd>
                <a href="<?php echo $this->createUrl('visaService/help');?>">签证协助</a>
                <a href="<?php echo $this->createUrl('page/travel_insurance');?>">旅游保险</a>
                <a href="<?php echo $this->createUrl('page/reviews')?>">评价回访</a>
                <a href="/tourQuestion">问题咨询</a>
            </dd>
        </dl>
        <dl>
            <dt>预订须知</dt>
            <dd>
                <a href="<?php echo $this->createUrl('page/customer_agreement');?>" rel="nofollow">客户协议</a>
                <a href="<?php echo $this->createUrl('page/privacy_policy');?>" rel="nofollow">隐私条例</a>
                <a href="<?php echo $this->createUrl('page/download_acknowledgement_card_billing');?>" rel="nofollow">信用卡支付验证书</a>
                <a href="<?php echo $this->createUrl('page/cancellation_and_refund_policy');?>" rel="nofollow">取消和修改条例</a>
            </dd>
        </dl>
        <dl>
            <dt>出行相关</dt>
            <dd>
                <a href="<?php echo $this->createUrl('page/guideForDestination');?>">目的地指南</a>
                <a href="<?php echo $this->createUrl('page/allprods');?>">所有景点</a>
                <a href="<?php echo $this->createUrl('page/siteMap');?>">网站地图</a>
                <a href="<?php echo $this->createUrl('download/magazine');?>" rel="nofollow">途风E游</a>
                <a href="<?php echo $this->createUrl('download/ebook');?>">途风美国出行指南</a>
            </dd>
        </dl>
        <dl>
            <dt>途风合作</dt>
            <dd>
                <a href="<?php echo $this->createUrl('affiliateCenter/index');?>" rel="nofollow">网站联盟</a>
                <a href="<?php echo $this->createUrl('page/links');?>">友情链接</a>
                <a href="<?php echo $this->createUrl('page/cooperation');?>" rel="nofollow">商务合作</a>
            </dd>
        </dl>
        <dl>
            <dt>关于我们</dt>
            <dd>
                <a href="<?php echo $this->createUrl('page/about_us_new');?>" rel="nofollow">关于我们</a>
                <a href="<?php echo $this->createUrl('page/contact_us');?>" rel="nofollow">联系我们</a>
                <a href="<?php echo $this->createUrl('page/copy_right');?>" rel="nofollow">版权</a>
            </dd>
        </dl>
        <div class="follow">
            <ul class="clearfix">
                <li>
                    <img width="84" height="122" alt="" src="/imgs/icon/qrcode_weibo.png">
                </li>
                <li>
                    <img width="84" height="122" alt="" src="/imgs/icon/qrcode_weixin.png">
                </li>
                <li>
                    <img width="84" height="122" alt="" src="/imgs/icon/qrcode_weixin2.png">
                </li>
            </ul>
            <?php //$this->Widget('application.widgets.SubscriberWidget')?>
        </div>
    </div>
</div>
<div class="copyright-wrap">
    <div class="copyright">
        <div class="foot-icon">
            <p class="yahei">合作伙伴</p>
            <div class="partner clearfix">
                <a href="http://www.ctrip.com" target="_blank">
                    <img src="/imgs/partner/partner_ctrip.jpg">
                </a>
                <a href="http://www.icbc.com.cn/icbc/hqlxk5/" target="_blank">
                    <img src="/imgs/partner/partner_icbc_01.jpg">
                </a>
                <a href="javascript:void(0);">
                    <img src="/imgs/partner/partner_icbc_02.jpg">
                </a>
                <a target="_blank" href="https://online.unionpay.com/portal/index.do">
                    <img src="/imgs/partner/partner_union.jpg">
                </a>
                <a target="_blank" href="https://www.paypal.com/c2/cgi-bin/webscr?cmd=_flow&amp;SESSION=KJuFGq7sdBSLWOmpruVj7a23dwgtDIfizwBi7XhXlWZZs6S1RTXPe3DcnaK&amp;dispatch=5885d80a13c0db1f8e263663d3faee8def8934b92a630e40b7fef61ab7e9fe63">
                    <img src="/imgs/partner/partner_pal.jpg">
                </a>
                <a href="javascript:;">
                    <img src="/imgs/partner/partner_nta.jpg">
                </a>
                <a href="javascript:;" onclick="window.open('https://seal.godaddy.com/verifySeal?sealID=JHB7BjZuQfcCFSc6MhAyuC5S3qQRzzxK24gqEeqD3P1BaIrexjaTR','newwindow','width=593,height=460');">
                    <img src="/imgs/partner/partner_un.jpg">
                </a>
                <a target="_blank" href="http://www.travelinsure.com/chinese/select/index.asp?32974">
                    <img src="/imgs/partner/partner_usi.jpg">
                </a>
                <a target="_blank" href="http://cn.discoverlosangeles.com/">
                    <img src="/imgs/partner/partner_losangeles.jpg">
                </a>
            </div>
        </div>
        <?php
        if (!empty($friendlylinks)) {
            echo '<div class="frend-links"><p>';
            foreach ($friendlylinks as $k => $link) {
                echo '<a href="' . $link['url'] . '" target="_blank" >' . $link['name'] . '</a>';
                if (($k + 1) % 34 == 0) {
                    echo ' </p><p>';
                }
            }
            echo '</p></div>';
        }
        ?>
        <div class="copyright-info">
            <span class="foot-tip" id="foot-tip">CST# 2096846-40</span>版权 &copy;2006-<?php echo date('Y');?> ToursForFun.com, 拥有最终解释权。<br>
            <span style="display: none;" class="foot-tip-txt" id="foot-tip-txt">美国加利福尼亚州要求旅行团销售方到州检察院注册，并在其所有广告上展示注册号。有效的注册号表明此旅行团销售方是依照法律注册的。</span>
            网站内价格和产品行程有可能会有更改变动，不做另行通知。<br>
            途风（携程旗下）ToursForFun.com不对文字错误引起的不便负任何责任，文字错误都会及时更正。<br>
            蜀ICP备10200285号
            <div class="cert1" >
            <a id="___szfw_logo___" href="https://search.szfw.org/cert/l/CX20140829005030005116" target="_blank"><img src="/img/common/cert1.png" align="absmiddle"></a>
            <?php if (!Yii::app()->request->getIsSecureConnection()) {
            echo '<a target="_blank" href="http://webscan.360.cn/index/checkwebsite/url/cn.toursforfun.com"><img border="0" width="100" height="40" src="http://img.webscan.360.cn/status/pai/hash/5c63acf19585cf3e92d1c1e5fe7af5de"/></a>';
            }?>
            <a  key ="0"  logo_size="83x30"  logo_type="realname"  href="https://www.anquan.org" ><script src="https://static.anquan.org/static/outer/js/aq_auth.js"></script></a>
            <script type="text/javascript">(function(){document.getElementById('___szfw_logo___').oncontextmenu = function(){return false;}})();</script>
            </div>
        </div>
    </div>
</div>
<!--右侧浮动按钮-->
<div class="tff-service">
    <ul>
        <li class="ser-top">
            <a href="javascript:scroll(0,0);"><span>回到顶部</span></a>
        </li>
        <li class="ser-online">
            <a class="new-window" href="http://tb.53kf.com/webCompany.php?arg=10039881"><span>在线咨询</span></a>
        </li>
        <li class="ser-email">
            <a href="/contact_us.php" target="_blank"><span>邮件咨询</span></a>
        </li>
        <li class="ser-tel">
        <a href="javascript:;">
            <span>866-638-6888<br>400-635-6555</span>
        </a>
        </li>
    </ul>
</div>
<?php
/**
 * ie7以下浏览器升级提示
 */
if (preg_match('/\bMSIE\s(\d+)/', $_SERVER['HTTP_USER_AGENT'], $msie_ver_info)) {
    header("X-UA-Compatible: IE=edge,chrome=1");
    if ((int)$msie_ver_info[1] < 7 && !isset($_COOKIE['browserupdator'])) {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/browserupdator.' . LANGUAGE_ID . '.js');
    }
}

/**
 * google分析跟踪代码
 */
if (IS_PROD_SITE) {
    $controller_id = strtolower(Yii::app()->getController()->getAction()->controller->id);
    $controller_action_id = strtolower(Yii::app()->getController()->getAction()->controller->action->id);

    // new google andlysis for nicole
    require_once('googleAnalytics/asia.php');
    require_once('googleAnalytics/australia_new_zealand.php');
    require_once('googleAnalytics/canada_tours.php');
    require_once('googleAnalytics/departing_from_china.php');
    require_once('googleAnalytics/europe_all.php');
    require_once('googleAnalytics/florida_tours.php');
    require_once('googleAnalytics/hawaii_all.php');
    require_once('googleAnalytics/hotel_tours.php');
    require_once('googleAnalytics/innovation_tours.php');
    require_once('googleAnalytics/latin_america_tours.php');
    require_once('googleAnalytics/us_east_all.php');
    require_once('googleAnalytics/us_west_all.php');
    require_once('googleAnalytics/visa_service.php');
    require_once('googleAnalytics/remarketingsetup.php');
    require_once('googleAnalytics/checkout_success.php');
    require_once('googleAnalytics/account.php');
    require_once('googleAnalytics/conversion_success.php');
    require_once('googleAnalytics/register_success.php');
}
if (strtolower(Yii::app()->getController()->getAction()->controller->id) == 'site' && strtolower(Yii::app()->getController()->getAction()->controller->action->id) == 'index') {
    ?>
    <!-- crazyegg跟踪代码 -->
    <script type="text/javascript">
        setTimeout(function () {
            var a = document.createElement("script");
            var b = document.getElementsByTagName("script")[0];
            a.src = document.location.protocol + "//dnn506yrbagrg.cloudfront.net/pages/scripts/0026/3433.js?" + Math.floor(new Date().getTime() / 3600000);
            a.async = true;
            a.type = "text/javascript";
            b.parentNode.insertBefore(a, b)
        }, 1);
    </script>
    <?php
    if (LANGUAGE_ID == 'tw') {
        echo '<script type="text/javascript">var CE_SNAPSHOT_NAME = "TFF Home Page（WWW）";</script>';
    } else {
        echo '<script type="text/javascript">var CE_SNAPSHOT_NAME = "TFF Home Page（CN）";</script>';
    }
}
if (IS_PROD_SITE)
    echo '<script type="text/javascript" src="https://bi.toursforfun.com/ta.js"></script>';
else if (IS_QA_SITE)
    echo '<script type="text/javascript" src="https://thack.toursforfun.com/ta.js"></script>';
?>
<?php
if (strtolower(Yii::app()->getController()->getAction()->controller->id) == 'site' && strtolower(Yii::app()->getController()->getAction()->controller->action->id) == 'australianewzealand') {
?>
<!-- crazyegg跟踪代码 -->
<script type="text/javascript">
    setTimeout(function () {
        var a = document.createElement("script");
        var b = document.getElementsByTagName("script")[0];
        a.src = document.location.protocol + "//dnn506yrbagrg.cloudfront.net/pages/scripts/0026/3433.js?" + Math.floor(new Date().getTime() / 3600000);
        a.async = true;
        a.type = "text/javascript";
        b.parentNode.insertBefore(a, b)
    }, 1);
</script>
<?php
}
?>
<?php// include '_baidu_cpro.php'; ?>
<?php// include '_google_tracker_code.php'; ?>
</body>
</html>