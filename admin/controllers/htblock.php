<?php
/*
 * @package BFStop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2017 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class BfstopControllerHtblock extends JControllerForm
{
	public function add()
	{
		$this->setRedirect(
			JRoute::_('index.php?option=com_bfstop&view=htblock', false)
		);
		return true;	
	}

	public function returnToFormWithMessage($ipaddress, $msg)
	{
		$application = JFactory::getApplication();
		$formdata = array("ipaddress" => $ipaddress);
		$application->setUserState('com_bfstop.edit.htblock.data', $formdata);
		$application->enqueueMessage($msg, 'warning');
		$this->setRedirect(
			JRoute::_('index.php?option=com_bfstop&view=htblock', false)
		);
	}
	public function save($key = null, $urlVar = null)
	{
		$logger = getLogger();
		$htaccess = new BFStopHtAccess(JPATH_ROOT, null);
		$input = JFactory::getApplication()->input;
		$formData = new JRegistry($input->get('jform', array(), 'array'));
		$ipaddress = $formData->get('ipaddress', '');
		$db = new BFStopDBHelper($logger);
		if ($db->isIPWhiteListed($ipaddress))
		{
			$logger->log("IP address '$ipaddress' is whitelisted! Will not block it via .htaccess", JLog::INFO);
			$this->returnToFormWithMessage($ipaddress, JText::_('COM_BFSTOP_IPADDRESS_WHITELISTED'));
			return false;
		}
		$result = $htaccess->denyIP($ipaddress);
		if ($result)
		{
			$logger->log("Added ipaddress '$ipaddress' to .htaccess from backend", JLog::INFO);
			$this->setRedirect(
				JRoute::_('index.php?option=com_bfstop&view=htblocklist', false)
			);
		}
		else
		{
			$this->returnToFormWithMessage($ipaddress, JText::_('COM_BFSTOP_INVALID_IPADDRESS'));
		}
		return $result;
	}
	public function cancel($key = null)
	{
		$application = JFactory::getApplication();
		$application->setUserState('com_bfstop.edit.htblock.data', array());
		$this->setRedirect(
			JRoute::_('index.php?option=com_bfstop&view=htblocklist',false)
		);
	}

}
