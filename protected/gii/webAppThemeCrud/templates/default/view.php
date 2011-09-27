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
		<h2 class="title"><?php echo $this->class2name($this->modelClass); ?>'s details</h2>
		<div class="inner">
			<?php echo '<?php'; ?> $this->widget('zii.widgets.CDetailView', array(
				'data' => $model,
				'attributes' => array(
<?php
foreach ($this->tableSchema->columns as $column)
{
	echo "\t\t\t\t\t'" . $column->name . "',\n";
}
?>
				),
				'itemTemplate' => "<tr class=\"{class}\"><td style=\"width: 120px\"><b>{label}</b></td><td>{value}</td></tr>\n",
				'htmlOptions' => array(
					'class' => 'table',
				),
			)); ?>
		</div>
	</div>
</div>