<?php
/*
 * @package BFStop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2017 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

class BfstopViewSettings extends JViewLegacy
{
	public function display($tpl = null)
	{
		$this->addToolbar();
		parent::display($tpl);
	}
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_BFSTOP_SUBMENU_SETTINGS'));
		JToolBarHelper::custom('settings.testNotify', 'preview', '',
			'TEST_NOTIFICATION', false, false);
	}
}
