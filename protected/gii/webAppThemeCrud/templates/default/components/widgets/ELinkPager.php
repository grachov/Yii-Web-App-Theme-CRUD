<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
class ELinkPager extends CLinkPager
{
	public function run()
	{
		$this->registerClientScript();
		$buttons = $this->createPageButtons();
		if (empty($buttons))
		{
			return;
		}
		$this->htmlOptions['class'] = trim($this->htmlOptions['class'] . ' pagination');
		echo CHtml::tag('div', $this->htmlOptions, implode("\n", $buttons));
	}

	protected function createPageButton($label, $page, $class, $hidden, $selected)
	{
		if ($hidden)
		{
			return false;
		}
		$class = str_replace(self::CSS_INTERNAL_PAGE, '', $class);
		$class .= ' ' . ($selected ? 'current active' : '');
		$class = trim($class);
		return $selected ? CHtml::tag('span', array('class' => $class), $label) : CHtml::link($label, $this->createPageUrl($page), array('class' => $class));
	}
}
