<?php
/*
 * @package BFStop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2018 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

class BFStopViewHTBlock extends JViewLegacy
{
	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->addToolbar();
		$document = JFactory::getDocument();
		$ds = DIRECTORY_SEPARATOR;
		$document->addStyleSheet(JURI::base(true).$ds.
			'components'.$ds.'com_bfstop'.$ds.'views'.$ds.
			'htblock'.$ds.'tmpl'.$ds.'edit.css');
		parent::display($tpl);
	}
	protected function addToolbar()
	{
		$input = JFactory::getApplication()->input;
		$input->set('hidemainmenu', true);
		JToolBarHelper::title(JText::_('COM_BFSTOP_BLOCK_NEW'));
		JToolBarHelper::save('htblock.save');
		JToolBarHelper::cancel('htblock.cancel', 'JTOOLBAR_CANCEL');
	}
}
