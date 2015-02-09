<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
	'Login',
);
//var_dump($model->name);
?>
<form id="formTest" action="http://cn.toursforfun.com/category/list">
start city: <input name="startCityId" value="655" />
end city: <input name="stopCityId" value="20443" />
    <input name="category_id" value="326">
    <input type="submit" value="submit">
</form>
<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
//    'action'=>'abd.php',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name');//$this->displayError('name');// ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php //echo $form->passwordField($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password');//$this->displayError('password');// ?>
		<p class="hint">
			Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
		</p>
	</div>

<!--	<div class="row rememberMe">-->
<!--		--><?php //echo $form->checkBox($model,'rememberMe'); ?>
<!--		--><?php //echo $form->label($model,'rememberMe'); ?>
<!--		--><?php //echo $form->error($model,'rememberMe'); ?>
<!--	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton(t('operation','REGISTER')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
