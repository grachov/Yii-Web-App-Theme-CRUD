<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
$url = CJavaScript::quote($this->createUrl('create'), true);
Yii::app()->clientScript
	->registerCoreScript('jquery')
	->registerScript('<?php echo $this->class2id($this->modelClass); ?>-grid-init', "
$('#<?php echo $this->class2id($this->modelClass); ?>-grid-actions button.action-create').live('click', function(){
	document.location.href = '{$url}';
	return false;
});
	");
$this->menu = array(
	array('label' => '<?php echo $this->pluralize($this->class2name($this->modelClass)); ?>', 'url' => array('index')),
	array('label' => 'Create <?php echo strtolower($this->class2name($this->modelClass)); ?>', 'url' => array('create')),
);
?>
<div class="block">
	<div class="content">
		<h2 class="title"><?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h2>
		<?php echo '<?php'; ?> $this->renderPartial('_grid', array(
			'model' => $model,
		)); ?>
	</div>
</div>