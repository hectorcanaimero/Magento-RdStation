<?php 

namespace Vanguarda\RdStation\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Data implements ObserverInterface {

    protected $jsonHelper;
    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->jsonHelper = $jsonHelper;
    }

    public function execute(Observer $observer) {
        $customer = $observer->getEvent()->getCustomer();
        echo "<script>console.log('ID => ".$customer->getId()."')</script>";
        echo "<script>console.log('Firstname => ".$customer->getFirstname()."')</script>";
        echo "<script>console.log('Email => ".$customer->getEmail()."')</script>";
        $data = array(
            'token_rdstation' => '62d9c778fa41b8ad8d694143731ceb6d',
            'identificador' => 'Magento 2',
            'email' => $customer->getEmail(),
            'nome' => $customer->getFirstname().' '.$customer->getLastname()
        );
        $encodeData = $this->jsonHelper->jsonEncode($data);
        echo "<script>console.log('Data => ".$encodeData."')</script>";
        // echo "<script>console.log('Data => ".$data."')</script>";
        $url = 'https://www.rdstation.com.br/api/1.3/conversions';
        $ch = curl_init($url);
        $payload = $encodeData;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

}

?>