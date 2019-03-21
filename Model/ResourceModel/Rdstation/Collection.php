<?php 

namespace eTatva\CRUD\Model\ResourceModel\Post;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
        /**
         * Define resource model
         *
         * @return void
         */
        protected function _construct()
        {
                $this->_init('eTatva\CRUD\Model\Post', 'eTatva\CRUD\Model\ResourceModel\Post');
        }
}

?>