<!DOCTYPE html>
<html>
    <head>
        <?php require_once('_head_tags.php'); ?>
    </head>
    <body>
        <div>
            <?php echo $this->loginUser ? $this->loginUser->name : ''; ?>
            <a href="<?php echo $this->createUrl('user/logout');?>">Logout(disable)</a>
        </div>
        <div class="navbar navbar-fixed-top" role="navigation" id="menu-nav">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="sr-only">切换导航</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">收账管理系统</a>
                </div>
            </div>
        </div>
        <!--   {#导航条#}-->
        <?php echo $content; ?>
        <?php require_once('_footer.php'); ?>
    </body>
</html>