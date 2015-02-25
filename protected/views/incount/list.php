<?php
/* @var $this IncountController */

$this->breadcrumbs=array(
	'Incount',
);
?>
<table>
    <tr>
        <td>customer</td>
        <td>money</td>
        <td>phone</td>
        <td>note</td>
        <td>addtime</td>
        <td>operation</td>
    </tr>
    <?php if (count($data) > 0) {
    foreach($data as $row) { ?>
        <tr>
            <td><?php echo $row->customer->name; ?></td>
            <td><?php echo $row->money?></td>
            <td><?php echo $row->phone?></td>
            <td><?php echo $row->note?></td>
            <td><?php echo $row->add_time?></td>
            <td><?php echo CHtml::link('modify', $this->createUrl('incount/create', array('incount_id'=>$row->incount_id)))
                    .'/'
                    .CHtml::link('delete', $this->createUrl('incount/delete', array('incount_id'=>$row->incount_id))); ?></td>
        </tr>
    <?php }
}?>
</table>
