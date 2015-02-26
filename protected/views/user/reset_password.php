<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
<table>
    <tr>
        <td><?php echo $form->labelEx($model, 'name'); ?></td>
        <td><?php echo $form->textField($model, 'name'); ?></td>
        <td><?php echo $form->error($model, 'name');?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'oldpassword'); ?></td>
        <td><?php echo $form->textField($model, 'oldpassword'); ?></td>
        <td><?php echo $form->error($model, 'oldpassword');?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::submitButton('submit'); ?></td>
        <td><?php echo CHtml::resetButton(); ?></td>
    </tr>
</table>
<?php $this->endWidget(); ?>
</div><!-- form -->