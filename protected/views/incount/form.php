<?php
$this ->breadcrumbs->add('进账', $this->createUrl('incount/create'));
$this ->breadcrumbs->display();
?>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'incount-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    <table>
        <tr>
            <td>借款人：</td>
            <td><input name="username" /></td>
        </tr>
        <tr>
            <td>金额：</td>
            <td><input name="money" /></td>
        </tr>
        <tr>
            <td>备注：</td>
            <td><textarea name="note"></textarea></td>
        </tr>
        <tr>
            <td><input type="submit" value="添加" /></td>
            <td><input type="reset" value="取消" /></td>
        </tr>
    </table>
<?php $this->endWidget(); ?>
</div><!-- form -->