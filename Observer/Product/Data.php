<?php 

namespace Vanguarda\RdStation\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;


class Data implements ObserverInterface {

    protected $jsonHelper;
    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->_scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer) {
        $this->scopeConfig = $scopeConfig;
        $customer = $observer->getEvent()->getCustomer();
        echo "<script>console.log('ID => ".$customer->getId()."')</script>";
        echo "<script>console.log('Firstname => ".$customer->getFirstname()."')</script>";
        echo "<script>console.log('Email => ".$customer->getEmail()."')</script>";
        $token = $this->scopeConfig->getValue('vanguarda_news/general/token', 'default');
        echo "<script>console.log('Token => ".$token."')</script>";
        // $data = array(
        //     'token_rdstation' => $token,
        //     'identificador' => 'Magento 2',
        //     'email' => $customer->getEmail(),
        //     'nome' => $customer->getFirstname().' '.$customer->getLastname()
        // );
        // $encodeData = $this->jsonHelper->jsonEncode($data);
        // echo "<script>console.log('Data => ".$encodeData."')</script>";
        // echo "<script>console.log('Data => ".$data."')</script>";
        // $url = 'https://www.rdstation.com.br/api/1.3/conversions';
        // $ch = curl_init($url);
        // $payload = $encodeData;
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_exec($ch);
        // curl_close($ch);
        exit;
    }

}

?>