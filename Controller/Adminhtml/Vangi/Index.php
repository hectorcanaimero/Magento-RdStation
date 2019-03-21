<?php
    namespace Vanguarda\RdStation\Controller\Adminhtml\Vangi;
    
    class Index extends \Magento\Backend\App\Action {
        /**
        * @var \Magento\Framework\View\Result\PageFactory
        */
        protected $resultPageFactory;
        /**
         * Constructor
         * @param \Magento\Backend\App\Action\Context $context
         * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
         */
        public function __construct(
            \Magento\Backend\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory
        ) {
             parent::__construct($context);
             $this->resultPageFactory = $resultPageFactory;
        }

        /**
         * Load the page defined in view/adminhtml/layout/config_vangi_index.xml
         * @return \Magento\Framework\View\Result\Page
         */
        public function execute() {
            $resultPage = $this->resultPageFactory->create(ResultFactory::TYPE_PAGE);
            return $resultPage;
        }
    }
?>
  