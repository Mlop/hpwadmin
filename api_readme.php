将后台PHP与前端HTML分开部署在两台服务器上，减少手机访问HTML使用的内存。因此，使用JSONP跨域请求数据，统一访问api/callback返回JSONP数据。使用示例如下：
//请求的URL地址如：http://local.hpw-vera.com/api/callback?callback=success_callback&sign=MV9hZG1pbl9xZmtvbmcjdHRr&controller=user&action=login&User%5Bname%5D=admin&User%5Bpassword%5D=admin&_=1425877999353
$.ajax({
    url: 'api/callback',
    dataType: 'jsonp',
    jsonpCallback:"success_callback",
    data:{'sign':'MV9hZG1pbl9xZmtvbmcjdHRr', 'controller':'user', 'action':'login', 'User[name]':'admin','User[password]':'admin'},
    success: function(data){
        //处理data数据
        console.log(data);
    },
    error:function(a,b,c){
        console.log('error');
    }
});
请求参数为:
sign：未登陆：授权用户名#动态码；已登陆：用户ID_用户名_授权用户名#动态码。
controller：类名
action：方法名
其余为参数。如果是表单类型，比如登陆、注册，数据形式为类名[字段名]。如：User[name]

3. 错误返回(ajax):
error: 0=无错误；>0表示错误码；
msg：错误说明信息；
示例：{'error':0,'msg':''}
4. 需要一个公共错误跳转页面，显示致命错误，如数据库错误
5. 请求入库错误返回:
error: 0=无错误（msg为正确返回的数据）；>0表示错误码(1=msg返回关联数组，报对应前端字段错误；2=msg返回字符串)；
msg：错误说明信息；
示例：{'error':0,'msg':''}
6. 接口
主要功能：
6.1. 用户User：
登陆、注销、注册、列表、修改、密码重置（自己找回和管理员直接重置）、删除
6.2. 贷款人/借款人Customer:
创建、删除、列表
6.3. 收入Incount:
创建、删除、列表
6.4. 支出Outcount:
创建、删除、列表
7. 接口详细说明
前端调用公共接口地址：api/callback?
请求方式POST/GET
7.1 登陆
URL： /user/login
Params:
User[name]:用户名
User[password]:密码
返回：
error: 0无错误
1 返回的错误是关联数组
2 返回的错误是字符串
7.2 注册
/user/register

