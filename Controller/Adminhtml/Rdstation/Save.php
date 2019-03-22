<?php

namespace Vanguarda\RdStation\Controller\Adminhtml\Rdstation;

use Magento\Backend\App\Action;
use Vanguarda\RdRstation\Model\Rdstation;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Vanguarda\RdStation\Model\RdstationFactory
     */
    private $allnewsFactory;

    /**
     * @var \Vanguarda\RdStation\Api\RdstationRepositoryInterface
     */
    private $allnewsRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Vanguarda\RdStation\Model\RdstationFactory $allnewsFactory
     * @param \Vanguarda\RdStation\Api\RdstationRepositoryInterface $allnewsRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Vanguarda\RdStation\Model\RdstationFactory $allnewsFactory = null,
        \Vanguarda\RdStation\Api\RdstationRepositoryInterface $allnewsRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->allnewsFactory = $allnewsFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Vanguarda\RdStation\Model\RdstationFactory::class);
        $this->allnewsRepository = $allnewsRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Vanguarda\RdStation\Api\RdstationRepositoryInterface::class);
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Vanguarda_RdStation::save');
	}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Allnews::STATUS_ENABLED;
            }
            if (empty($data['vangi_id'])) {
                $data['vangi_id'] = null;
            }

            /** @var \Vanguarda\RdStation\Model\Rdstation $model */
            $model = $this->allnewsFactory->create();

            $id = $this->getRequest()->getParam('vangi_id');
            if ($id) {
                try {
                    $model = $this->allnewsRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This news no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'news_allnews_prepare_save',
                ['allnews' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->allnewsRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the news.'));
                $this->dataPersistor->clear('news_allnews');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['news_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the news.'));
            }

            $this->dataPersistor->set('news_allnews', $data);
            return $resultRedirect->setPath('*/*/edit', ['vangi_id' => $this->getRequest()->getParam('vangi_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
