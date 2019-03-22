<?php

namespace Vanguarda\RdStation\Controller\Adminhtml\Rdstation;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory

class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;

	public function __construct( Context $context, PageFactory $resultPageFactory ) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed() {
		return $this->_authorization->isAllowed('Vanguarda_RdStation::rd');
	}

	public function execute() {
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend(__('Rd Station'));
		return $resultPage;
	}
}