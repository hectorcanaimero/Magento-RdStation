<?php 

namespace Vanguarda\RdStation\Observer\Product;

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
        // echo "<script>console.log('ID => ".$customer->getId()."')</script>";
        // echo "<script>console.log('Firstname => ".$customer->getFirstname()."')</script>";
        // echo "<script>console.log('Email => ".$customer->getEmail()."')</script>";
        // $token = $this->scopeConfig->getValue('vanguarda_news/general/token', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        // echo "<script>console.log('Token => ".$token."')</script>";
        $data = array(
            'token_rdstation' => $this->scopeConfig->getValue('vanguarda_news/general/token', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            'identificador' => 'Magento 2',
            'email' => $customer->getEmail(),
            'nome' => $customer->getFirstname().' '.$customer->getLastname()
        );
        $encodeData = $this->jsonHelper->jsonEncode($data);
        // echo "<script>console.log('Data => ".$encodeData."')</script>";
        $ch = curl_init('https://www.rdstation.com.br/api/1.3/conversions');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodeData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        // exit;
    }

}

?>