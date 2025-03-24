<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Controller\Adminhtml\Shopfinder;

use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Hawksama\ShopfinderGraphQL\Model\ShopfinderModelFactory;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class Delete extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Hawksama_ShopfinderGraphQL::management';

    public function __construct(
        Context                                 $context,
        private readonly ShopfinderModelFactory $modelFactory,
        private readonly ShopfinderResource     $resource,
        private readonly LoggerInterface        $logger
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');
        $entityId = (int)$this->getRequest()->getParam(ShopfinderInterface::SHOP_ID);

        try {
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, ShopfinderInterface::SHOP_ID);

            if (!$model->getId()) {
                throw new NoSuchEntityException(
                    __('Could not find Notice with id: %1', $entityId)
                );
            }

            $this->resource->delete($model);
            $this->messageManager->addSuccessMessage(__('You have successfully deleted the Shop entity.'));
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            $this->logger->error(
                __('Could not delete Notice. Original message: %1', $exception->getMessage()),
                ['exception' => $exception]
            );
            $this->messageManager->addErrorMessage(__('An error occurred while deleting the Notice.'));
        }

        return $resultRedirect;
    }
}
