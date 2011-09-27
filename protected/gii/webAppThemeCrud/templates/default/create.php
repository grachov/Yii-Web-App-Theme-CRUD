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
);
?>
<div class="block">
	<div class="content">
		<h2 class="title">Create new <?php echo strtolower($this->class2name($this->modelClass)); ?></h2>
		<div class="inner">
			<?php echo '<?php'; ?> $this->renderPartial('_form', array(
				'model' => $model,
			)); ?>
		</div>
	</div>
</div>