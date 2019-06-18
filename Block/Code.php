<?php

namespace Vanguarda\RdStation\Block;

use \Magento\Framework\App\Config\ScopeConfigInterface;
class Code extends \Magento\Framework\View\Element\Template {
    
  public $scopeConfig;

  public function __construct(ScopeConfigInterface $scopeConfig) {
    $this->scopeConfig = $scopeConfig;
}

  public function getMonitoreamento() {
    $datos = $this->getConfig('vanguarda_news/general/monitoreamento');
    return $datos;
  } 

  public function getConfig($configPath, $scope = 'default'){
    return $this->scopeConfig->getValue(
      $configPath,
      \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
      $scope
    );
  }

  public function Muestratexto(){
    return 'Hola mundo';
  }

}

?>