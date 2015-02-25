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
        <td><?php echo $form->labelEx($model, 'customerName'); ?></td>
        <td><?php echo $form->textField($model, 'customerName'); ?></td>
        <td><?php echo $form->error($model, 'customerName');?><?php echo $form->textField($model, 'customer_id'); ?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'money'); ?></td>
        <td><?php echo $form->telField($model, 'money'); ?></td>
        <td><?php echo $form->error($model, 'money');?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'phone'); ?></td>
        <td><?php echo $form->telField($model, 'phone'); ?></td>
        <td><?php echo $form->error($model, 'phone');?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'note'); ?></td>
        <td><?php echo $form->textArea($model, 'note'); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::submitButton('submit'); ?></td>
        <td><?php echo CHtml::resetButton(); ?></td>
    </tr>
</table>
<?php $this->endWidget(); ?>
</div><!-- form -->