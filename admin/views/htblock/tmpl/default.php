<?php
/*
 * @package BFStop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2018 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;
?>
<form method="post" name="adminForm" id="adminForm">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_BFSTOP_BLOCK_DETAILS'); ?></legend>
		<ul class="adminformlist">
<?php foreach($this->form->getFieldset() as $field): ?>
			<li><?php echo $field->label; echo $field->input; ?></li>
<?php endforeach; ?>
		</ul>
	</fieldset>
	<input type="hidden" name="task" value="htblock.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
