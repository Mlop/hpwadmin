1.��־д���ļ���
a. ��dev.php�е�'preload'=>array('log')
b. Yii::log('1233', 'error');
c. ��־����д�뵽�ļ�D:\wamp\www\hpw\protected\runtime\application.log��
2. ������м��
$this->breadcrumbs->add('��ҳ', $this->baseUrl);
��ʾ��$this->breadcrumbs->display();
3. ���󷵻�(ajax):
error: 0=�޴���>0��ʾ�����룻
msg������˵����Ϣ��
ʾ����{'error':0,'msg':''}
4. ��Ҫһ������������תҳ�棬��ʾ�������������ݿ����
5. ���������󷵻�:
error: 0=�޴���msgΪ��ȷ���ص����ݣ���>0��ʾ������(1=msg���ع������飬����Ӧǰ���ֶδ���2=msg�����ַ���)��
msg������˵����Ϣ��
ʾ����{'error':0,'msg':''}
6. �ӿ�
��Ҫ���ܣ�
6.1. �û�User��
��½��ע����ע�ᡢ�б��޸ġ��������ã��Լ��һغ͹���Աֱ�����ã���ɾ��
6.2. ������/�����Customer:
������ɾ�����б�
6.3. ����Incount:
������ɾ�����б�
6.4. ֧��Outcount:
������ɾ�����б�
7. �ӿ���ϸ˵��
ǰ�˵��ù����ӿڵ�ַ��api/callback?
����ʽPOST/GET
7.1 ��½
URL�� /user/login
Params:
User[name]:�û���
User[password]:����
���أ�
error: 0�޴���
1 ���صĴ����ǹ�������
2 ���صĴ������ַ���
7.2 ע��
/user/register

