<?php

namespace Vanguarda\RdStation\Observer\RdStation;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use \Magento\Framework\Json\Helper\Data;
use \Magento\Framework\App\Config\ScopeConfigInterface;


class Abandoned implements ObserverInterface {
    
    protected $jsonHelper;
    protected $scopeConfig;
    protected $logger;
    
    public function __construct( 
        Data $jsonHelper, 
        ScopeConfigInterface $scopeConfig, 
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $loggerInterface;
    }

    public function execute(Observer $observer) {
        $quoteItem = $observer->getEvent()->getItem();
        if (!$quoteItem->getId() && !$quoteItem->getParentItem()) {
            $productId = $quoteItem->getProductId();
            $this->logger->debug($productId);
        }
        printf($quoteItem);
        die();
    }
}

?>