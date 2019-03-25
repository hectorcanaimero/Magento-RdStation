<?php

namespace Vanguarda\RdStation\Helper;
 
use Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper {
 
    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfig($text) {
        $datos = $this->scopeConfig->getValue($text, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $datos;
    }
 
}

?>