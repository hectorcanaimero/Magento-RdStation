<?php
namespace Vanguarda\RdStation\Model\ResourceModel\Rdstation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'vangi_id';
	
	protected $_eventPrefix = 'news_allnews_collection';

    protected $_eventObject = 'allnews_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('Vanguarda\RdStation\Model\Rdstation', 'Vanguarda\RdStation\Model\ResourceModel\Rdstation');
	}
}