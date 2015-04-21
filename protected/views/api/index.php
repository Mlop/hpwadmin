<form action="api/callback">
<input name="controller" value="user" />
<input name="action" value="login" />
<input name="sign" value="MV9hZG1pbl9xZmtvbmcjdHRr" />
    <input name="User[password]" value="" />
<input type="submit" value="submit" />
</form>
<script type="text/javascript" src="/js/jQuery/jquery-1.11.2.min.js"></script>

<script type="text/javascript">
    $(function(){
        //请求的URL地址如：http://local.hpw-vera.com/api/callback?callback=success_jsonpCallback&sign=MV9hZG1pbl9xZmtvbmcjdHRr&controller=user&action=login&User%5Bname%5D=admin&User%5Bpassword%5D=admin&_=1425877999353
        $.ajax({
            url: 'api/callback',
            dataType: 'jsonp',
            jsonpCallback:"success_jsonpCallback",
            data:{'sign':'MV9hZG1pbl9xZmtvbmcjdHRr', 'controller':'user', 'action':'login', 'User[name]':'admin','User[password]':'admin'},
            success: function(data){
                //处理data数据
                console.log(data);
            },
            error:function(a,b,c){
                console.log('error');
            }
        });
    });
</script>