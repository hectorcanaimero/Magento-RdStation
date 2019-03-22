<?php
namespace Vanguarda\RdStation\Block\Adminhtml;

class Rdstation extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_rdstation';
        $this->_blockGroup = 'Vanguarda_RdStation';
        $this->_headerText = __('Config Rd Station');

        parent::_construct();

        if ($this->_isAllowedAction('Vanguarda_RdStation::save')) {
            $this->buttonList->update('add', 'label', __('Add News'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
?>