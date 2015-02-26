<?php
/* @var $this IncountController */
$this->breadcrumbs->display();
//$this->breadcrumbs=array(
//	'Incount',
//);
?>
<table>
    <tr>
        <td>name</td>
<!--        <td>add_time</td>-->
<!--        <td>last_login_time</td>-->
        <td>operation</td>
    </tr>
    <?php if (count($data) > 0) {
    foreach($data as $row) { ?>
        <tr>
            <td><?php echo $row->name; ?></td>
<!--            <td>--><?php //echo $row->add_time?><!--</td>-->
<!--            <td>--><?php //echo $row->last_login_time?><!--</td>-->
            <td><?php echo CHtml::link('modify', $this->createUrl('user/create', array('user_id'=>$row->user_id)))
                    .'/'
                    .CHtml::link('delete', $this->createUrl('user/delete', array('user_id'=>$row->user_id)))
                    .'/'
                    .CHtml::link('ResetPasswd', $this->createUrl('user/resetPasswd', array('user_id'=>$row->user_id))); ?>
            </td>
        </tr>
    <?php }
}?>
</table>
