<?php
namespace Vanguarda\RdStation\Controller\Adminhtml\RdStation;

use Magento\Backend\App\Action\Context;
use Vanguarda\RdStation\Api\RdstationRepositoryInterface as AllnewsRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Vanguarda\RdStation\Api\Data\RdStationInterface;

class InlineEdit extends \Magento\Backend\App\Action {
    protected $allnewsRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context $context,
        AllnewsRepository $allnewsRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->allnewsRepository = $allnewsRepository;
        $this->jsonFactory = $jsonFactory;
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed() {
		return $this->_authorization->isAllowed('Vanguarda_RdStation::save');
	}

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $newsId) {
            $news = $this->allnewsRepository->getById($newsId);
            try {
                $newsData = $postItems[$newsId];
                $extendedNewsData = $news->getData();
                $this->setNewsData($news, $extendedNewsData, $newsData);
                $this->allnewsRepository->save($news);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithNewsId($news, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithNewsId($news, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithNewsId(
                    $news,
                    __('Something went wrong while saving the news.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithNewsId(AllnewsInterface $news, $errorText) {
        return '[News ID: ' . $news->getId() . '] ' . $errorText;
    }

    public function setNewsData(\Rsgitech\News\Model\Allnews $news, array $extendedNewsData, array $newsData) {
        $news->setData(array_merge($news->getData(), $extendedNewsData, $newsData));
        return $this;
    }
}
