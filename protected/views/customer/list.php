<?php
$userType = CustomerForm::getTypeListData();
?>
<table>
    <tr>
        <td>name</td>
        <td>type</td>
        <td>operation</td>
    </tr>
    <?php if (count($data) > 0) {
    foreach($data as $row) { ?>
        <tr>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $userType[(int)$row->type]?></td>
            <td><?php echo CHtml::link('modify', $this->createUrl('customer/create', array('customer_id'=>$row->customer_id)))
                    .'/'
                    .CHtml::link('delete', $this->createUrl('customer/delete', array('customer_id'=>$row->customer_id))); ?></td>
        </tr>
    <?php }
}?>
</table>
