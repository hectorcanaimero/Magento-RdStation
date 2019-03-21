<?php 

namespace Vanguarda\RdStation\Model\ResourceModel\Rdstation;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
        /**
         * Define resource model
         *
         * @return void
         */
        protected function _construct() {
            $this->_init('Vanguarda\RdStation\Model\Rdstation', 'Vanguarda\RdStation\Model\ResourceModel\Rdstation');
        }
}

?>