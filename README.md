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