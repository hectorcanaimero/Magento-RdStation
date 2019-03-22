<?php 

namespace Vanguarda\RdRstation\Model;

use Vanguarda\RdRstation\Api\Data\RdstationInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Rdstation extends AbstractModel {
    
	const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'vanguarda_rdstation';
	
	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;
	
	protected function _construct() {
        $this->_init('Vanguarda\RdRstation\Model\ResourceModel\Rdstation');
    }
	
    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues() {
        $values = [];
        return $values;
    }

    public function getAvailableStatuses() {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getId()
	{
		return parent::getData(self::VANGI_ID);
	}

	public function getTitle()
	{
		return $this->getData(self::TOKEN);
	}

	public function getMonitor()
	{
		return $this->getData(self::MONITOR);
	}

	public function getStatus()
	{
		return $this->getData(self::STATUS);
	}

	public function getCreatedAt()
	{
		return $this->getData(self::CREATED_AT);
	}

	public function getUpdatedAt()
	{
		return $this->getData(self::UPDATED_AT);
	}

	public function setId($id)
	{
		return $this->setData(self::VANGI_ID, $id);
	}

	public function setTitle($title)
	{
		return $this->setData(self::TOKEN, $title);
	}

	public function setMonitor($description)
	{
		return $this->setData(self::MONITOR, $description);
	}

	public function setStatus($status)
	{
		return $this->setData(self::STATUS, $status);
	}

	public function setCreatedAt($created_at)
	{
		return $this->setData(self::CREATED_AT, $created_at);
	}

	public function setUpdatedAt($updated_at)
	{
		return $this->setData(self::UPDATED_AT, $updated_at);
	}
}

?>