<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo '<?php'; ?> $this->beginContent('//<?php echo $this->relativeLayoutPath; ?>/main'); ?>
	<div id="main">
		<div class="block">
			<div class="content">
				<?php echo '<?php'; ?> echo $content; ?>
			</div>
		</div>
		<?php echo '<?php'; ?> echo $this->renderPartial('//<?php echo $this->relativeLayoutPath; ?>/_footer'); ?>
	</div>
	<div id="sidebar">
		<div class="block">
			<h3>Operations</h3>
			<?php echo '<?php'; ?> $this->widget('zii.widgets.CMenu', array(
				'items' => $this->menu,
				'htmlOptions' => array(
					'class' => 'navigation',
				),
			)); ?>
		</div>
	</div>
<?php echo '<?php $this->endContent(); ?>'; ?>