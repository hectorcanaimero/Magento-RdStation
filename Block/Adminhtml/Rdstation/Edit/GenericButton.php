<?php

namespace Vanguarda\RdStation\Block\Adminhtml\Rdstation\Edit;

use Magento\Backend\Block\Widget\Context;
use Vanguarda\RdStation\Api\RdstationRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allnewsRepository;
    
    public function __construct(
        Context $context,
        RdstationRepositoryInterface $allnewsRepository
    ) {
        $this->context = $context;
        $this->allnewsRepository = $allnewsRepository;
    }

    public function getNewsId()
    {
        try {
            return $this->allnewsRepository->getById(
                $this->context->getRequest()->getParam('vangi_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
?>