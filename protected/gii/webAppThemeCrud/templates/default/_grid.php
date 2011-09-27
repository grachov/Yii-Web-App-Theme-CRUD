<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo '<?php'; ?> $provider = $model->search(); ?>
<div class="inner" id="<?php echo $this->class2id($this->modelClass); ?>-grid-inner">
	<?php echo '<?php'; ?> $this->widget('zii.widgets.grid.CGridView', array(
		'id' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
		'summaryText' => '<?php echo $this->pluralize($this->class2name($this->modelClass)); ?> {start} - {end} of {count}',
		'emptyText' => 'There are no data to display',
		'updateSelector' => '#<?php echo $this->class2id($this->modelClass); ?>-grid-actions .pagination a, #<?php echo $this->class2id($this->modelClass); ?>-grid .table thead th a',
		'afterAjaxUpdate' => "js:function(id, data){var id = '#' + id + '-actions'; \$(id).replaceWith(\$(id, '<div>' + data + '</div>'))}",
		'selectableRows' => 0,
		'showTableOnEmpty' => false,
		'dataProvider' => $provider,
		'cssFile' => false,
		'itemsCssClass' => 'table',
		'pagerCssClass' => 'pagination',
		'template' => '{items}',
		'columns' => array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column)
{
	if (++$count == 7)
	{
		echo "\t\t\t/*\n";
	}
	echo "\t\t\t'" . $column->name . "',\n";
}
if ($count >= 7)
{
	echo "\t\t\t*/\n";
}
?>
			array(
				'class' => 'EButtonColumn',
				'deleteConfirmation' => 'Do you really want to delete this <?php echo strtolower($this->class2name($this->modelClass)); ?>?',
			),
		),
	)); ?>
	<div class="actions-bar wat-cf" id="<?php echo $this->class2id($this->modelClass); ?>-grid-actions">
		<div class="actions">
			<button class="button action-create" type="button">
				<?php echo '<?php'; ?> echo CHtml::image(Yii::app()->request->baseUrl . '/images/create.png', 'Create'); ?> Create <?php echo strtolower($this->class2name($this->modelClass)) . "\n"; ?>
			</button>
		</div>
		<?php echo '<?php'; ?> $this->widget('application.components.widgets.ELinkPager', array(
			'cssFile' => false,
			'pages' => $provider->getPagination(),
		)); ?>
	</div>
</div>