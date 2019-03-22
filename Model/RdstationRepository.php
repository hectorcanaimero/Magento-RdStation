<?php

namespace Vanguarda\RdStation\Model;

use Vanguarda\RdStation\Api\Data;
use Vanguarda\RdStation\Api\RdstationRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Vanguarda\RdStation\Model\ResourceModel\Rdstation as ResourceAllnews;
use Vanguarda\RdStation\Model\ResourceModel\Rdstation\CollectionFactory as AllnewsCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class RdstationRepository implements AllnewsRepositoryInterface {
    protected $resource;

    protected $allnewsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAllnewsFactory;

    private $storeManager;

    public function __construct(
        ResourceAllnews $resource,
        RdstationFactory $allnewsFactory,
        Data\RdstationInterfaceFactory $dataAllnewsFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->allnewsFactory = $allnewsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAllnewsFactory = $dataAllnewsFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Vanguarda\RdStation\Api\Data\RdstationInterface $news)
    {
        if ($news->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $news->setStoreId($storeId);
        }
        try {
            $this->resource->save($news);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the news: %1', $exception->getMessage()),
                $exception
            );
        }
        return $news;
    }

    public function getById($newsId)
    {
		$news = $this->allnewsFactory->create();
        $news->load($newsId);
        if (!$news->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $newsId));
        }
        return $news;
    }
	
    public function delete(\Vanguarda\RdStation\Api\Data\RdstationInterface $news)
    {
        try {
            $this->resource->delete($news);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the news: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($newsId)
    {
        return $this->delete($this->getById($newsId));
    }
}
?>