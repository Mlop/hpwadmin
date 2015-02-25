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
    </tr>
    <?php if (count($data) > 0) {
    foreach($data as $row) { ?>
        <tr>
            <td><?php echo $row->customer->name; ?></td>
            <td><?php echo $row->money?></td>
            <td><?php echo $row->phone?></td>
            <td><?php echo $row->note?></td>
            <td><?php echo $row->add_time?></td>
        </tr>
    <?php }
}?>
</table>
