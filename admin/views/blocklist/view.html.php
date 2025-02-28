<?php
/*
 * @package BFStop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

// import Joomla view library
jimport('joomla.application.component.view');

require_once(JPATH_ADMINISTRATOR.'/components/com_bfstop/helpers/links.php');

class BFStopViewBlockList extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->items      = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$state            = $this->get('State');
		$this->sortColumn = $state->get('list.ordering');
		$this->sortDirection = $state->get('list.direction');
		$this->addToolBar();
		if (class_exists("JHtmlSidebar") && JVersion::MAJOR_VERSION < 4)
		{
			$this->sidebar = JHtmlSidebar::render();
		}
		parent::display($tpl);
	}

	function getBlockedState($item)
	{
		if ($item->unblocked != null) {
			return JText::sprintf('UNBLOCKED_STATE', $item->unblocked);
		} else {
			if ($item->duration == 0) {
				return JText::_('BLOCKED_PERMANENTLY');
			} else {
				$blockedUntil = strtotime($item->crdate);
				$blockedUntil += $item->duration*60;
				$strDate = date('Y-m-d H:i:s', $blockedUntil);
				return ($blockedUntil < time())
					? JText::sprintf('BLOCK_EXPIRED_AT', $strDate)
					: JText::sprintf('BLOCKED_UNTIL', $strDate);
			}
		}
	}

	function convertDurationToReadable($duration)
	{
		if ($duration == 0) {
			return JText::_('COM_BFSTOP_BLOCK_UNLIMITED');
		} else if ($duration >= 1 && $duration <= 59) {
			return JText::_('COM_BFSTOP_BLOCK_'.$duration.'MINUTES');
		} else if ($duration == 60) {
			return JText::_('COM_BFSTOP_BLOCK_1HOUR');
		} else {
			return JText::_('COM_BFSTOP_BLOCK_'.($duration/60).'HOURS');
		}
	}

	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_BFSTOP_HEADING_BLOCKLIST'), 'bfstop');
		JToolBarHelper::divider();
		// batch unblock would require rewrite of unblock method to check
		// for selected lines
		JToolBarHelper::custom('blocklist.unblock', 'unpublish.png', 'unpublish_f2.png', 'COM_BFSTOP_UNBLOCK', true);
		JToolBarHelper::editList('block.edit');
		JToolBarHelper::addNew('block.add');
		$user = JFactory::getUser();
		if ($user->authorise('core.admin', 'com_bfstop') || $user->authorise('core.options', 'com_bfstop'))
		{
			JToolbarHelper::preferences('com_bfstop');
		}
	}
}
