1.日志写入文件：
a. 打开dev.php中的'preload'=>array('log')
b. Yii::log('1233', 'error');
c. 日志内容写入到文件D:\wamp\www\hpw\protected\runtime\application.log中
2. 添加面包屑：
$this->breadcrumbs->add('首页', $this->baseUrl);
显示：$this->breadcrumbs->display();
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

