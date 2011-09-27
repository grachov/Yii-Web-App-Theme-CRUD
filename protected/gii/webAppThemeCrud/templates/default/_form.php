<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
$firstColumn = null;
foreach ($this->tableSchema->columns as $column)
{
	if ($column->autoIncrement)
	{
		continue;
	}
	if ($firstColumn == null)
	{
		$firstColumn = $column->name;
		break;
	}
}
?>
<?php echo '<?php'; ?> $form = $this->beginWidget('CActiveForm', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-form',
	'enableAjaxValidation' => false,
<?php echo $firstColumn != null ? "\t'focus' => array(\$model, '{$firstColumn}'),\n" : ''; ?>
	'htmlOptions' => array(
		'class' => 'form',
	),
)); ?>
<?php foreach($this->tableSchema->columns as $column): ?>
	<?php if (!$column->autoIncrement): ?>
<?php echo "\n\t"; ?><div class="group">
		<?php echo '<?php'; ?> if($model->hasErrors('<?php echo $column->name; ?>')): ?>
			<div class="fieldWithErrors">
		<?php echo '<?php'; ?> endif; ?>
		<?php echo '<?php echo ' . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
		<?php echo '<?php'; ?> if ($model->hasErrors('<?php echo $column->name; ?>')): ?>
				<span class="error"><?php echo '<?php'; ?> echo $model->getError('<?php echo $column->name; ?>'); ?></span>
			</div>
		<?php echo '<?php'; ?> endif; ?>
		<?php echo '<?php echo ' . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
	</div>
	<?php endif; ?>
<?php endforeach; ?>
<?php echo "\n\t"; ?><div class="group navform wat-cf">
		<button class="button" type="submit">
			<?php echo '<?php'; ?> echo CHtml::image(Yii::app()->request->baseUrl . '/images/save.png', $model->isNewRecord ? 'Create' : 'Save'); ?> <?php echo '<?php'; ?> echo $model->isNewRecord ? 'Create' : 'Save'; ?>
		</button>
		<span class="text_button_padding">or</span>
		<?php echo '<?php'; ?> echo CHtml::link('Cancel', array('index'), array('class' => 'text_button_padding link_button')); ?>
	</div>
<?php echo '<?php'; ?> $this->endWidget(); ?>