<?php 

namespace Vanguarda\RdStation\Observer\RdStation;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class Data implements ObserverInterface {

    protected $jsonHelper;
    protected $scopeConfig;

    public function __construct(\Magento\Framework\Json\Helper\Data $jsonHelper, ScopeConfigInterface $scopeConfig) {
        $this->jsonHelper = $jsonHelper;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer) {
        $customer = $observer->getEvent()->getCustomer();
        $data = array(
            'token_rdstation' => $this->scopeConfig->getValue('vanguarda_news/general/token', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            'identificador' => $this->scopeConfig->getValue('vanguarda_rdstaton/conversor/conversor_cliente', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            'email' => $customer->getEmail(),
            'Nome' => $customer->getFirstname().' '.$customer->getLastname()
        );
        $encodeData = $this->jsonHelper->jsonEncode($data);
        $url = 'https://www.rdstation.com.br/api/1.3/conversions';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodeData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        // exit;
    }

}

?>