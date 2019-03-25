<?php 

namespace Vanguarda\RdStation\Observer\RdStation;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Completed implements ObserverInterface {

    protected $_orderRepositoryInterface;    
    protected $_checkoutSession;
    protected $jsonHelper;
    protected $scopeConfig;
    protected $_customerRepositoryInterface;
    protected $customer;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepositoryInterface,
        \Magento\Customer\Model\Customer $customer,
        \Magento\Framework\Json\Helper\Data  $jsonHelper, 
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {  
        $this->_orderRepositoryInterface = $orderRepositoryInterface;
        $this->_checkoutSession = $checkoutSession;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->jsonHelper = $jsonHelper;
        $this->scopeConfig = $scopeConfig;
        $this->customer =$customer;
    }


    public function execute(Observer $observer ) {        
        $orderIds = $observer->getEvent()->getOrderIds();
        if (count($orderIds)) {
            $orderId = $orderIds[0];            
            $order = $this->_orderRepositoryInterface->get($orderId);
            $customerId = $order->getCustomerId();
            $customers = $this->_customerRepositoryInterface->getById($customerId);
            $produtos = '';
            foreach ($order->getAllVisibleItems() as $item){
                $produtos .= $item->getName().', ';
            } 
            $data = array(
                'token_rdstation' => $this->scopeConfig->getValue('vanguarda_news/general/token', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                'identificador' => $this->scopeConfig->getValue('vanguarda_rdstaton/conversor/conversor_compra', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                'email' => $customers->getEmail(),
                'Nome' => $customers->getFirstname().' '.$customers->getLastname(),
                'Telefone' => $order->getShippingAddress()->getTelephone(),
                'total_compra' => $order->getData('grand_total'),
                'quantidade_produtos' => $order->getData('total_item_count'),
                'produtos' => $produtos,
                'Id_order' => $orderId
            );
            $encodeData = $this->jsonHelper->jsonEncode($data);
            echo "<script>console.log('Data => ".$encodeData."')</script>";
            $url = 'https://www.rdstation.com.br/api/1.3/conversions';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodeData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
}

?>