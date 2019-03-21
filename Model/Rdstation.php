<?php

namespace Vanguarda\RdStation\Model;
 
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface {
    
    protected function _construct() {
        $this->_init('eTatva\CRUD\Model\ResourceModel\Post');
    }

    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues() {
        $values = [];
        return $values;
    }
}

?>