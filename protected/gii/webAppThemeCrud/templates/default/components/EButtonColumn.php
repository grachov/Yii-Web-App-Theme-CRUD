<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
Yii::import('zii.widgets.grid.CButtonColumn');

class EButtonColumn extends CButtonColumn
{
	public function init()
	{
		$url = Yii::app()->request->baseUrl . '/images/';
		$this->viewButtonImageUrl = $url . 'view.png';
		$this->updateButtonImageUrl = $url . 'update.png';
		$this->deleteButtonImageUrl = $url . 'delete.png';
		parent::init();
	}
}
