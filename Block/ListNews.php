<?php

namespace Vanguarda\RdStation\Block;

Class ListNews extends \Magento\Framework\View\Element\Template {
	protected $allNewsFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Vanguarda\RdStation\Model\RdstationFactory $allNewsFactory
	){
		parent::__construct($context);
		$this->allNewsFactory = $allNewsFactory;
	}
	
	public function getBaseUrl() {
		return $this->_storeManager->getStore()->getBaseUrl();
	}
	
	public function getListNews() {
		$page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
		$limit = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 2;
		
		$collection = $this->allNewsFactory->create()->getCollection();
		$collection->addFieldToFilter('status',1);
		$collection->setPageSize($limit);
		$collection->setCurPage($page);
	
		return $collection;
	}
	
	protected function _prepareLayout() {
		parent::_prepareLayout();
		$this->pageConfig->getTitle()->set(__('Latest News'));
		
		if ($this->getListNews()){
			$pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'vanguarda.rdstation.pager')
									->setAvailableLimit(array(2=>2,10=>10,15=>15,20=>20))
									->setShowPerPage(true)
									->setCollection($this->getListNews());

			$this->setChild('pager', $pager);

			$this->getListNews()->load();
		}
        return $this;
	}
	
	public function getPagerHtml() {
		return $this->getChildHtml('pager');
	}
}