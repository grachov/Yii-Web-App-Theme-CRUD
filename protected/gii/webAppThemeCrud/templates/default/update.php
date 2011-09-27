<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
$this->menu = array(
	array('label' => '<?php echo $this->pluralize($this->class2name($this->modelClass)); ?>', 'url' => array('index')),
	array('label' => 'Create <?php echo strtolower($this->class2name($this->modelClass)); ?>', 'url' => array('create')),
	array('label' => 'Update <?php echo strtolower($this->class2name($this->modelClass)); ?>', 'url' => array('update', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label' => 'Delete <?php echo strtolower($this->class2name($this->modelClass)); ?>', 'url' => '#', 'linkOptions' => array(
		'submit' => array('delete', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>),
		'confirm' => 'Do you really want to delete this <?php echo strtolower($this->class2name($this->modelClass)); ?>?',
	)),
);
?>
<div class="block">
	<div class="content">
		<h2 class="title">Update <?php echo strtolower($this->class2name($this->modelClass)); ?></h2>
		<div class="inner">
			<?php echo '<?php'; ?> $this->renderPartial('_form', array(
				'model' => $model,
			)); ?>
		</div>
	</div>
</div>