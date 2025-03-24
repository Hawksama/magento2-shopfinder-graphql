<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Controller\Adminhtml\Shopfinder;

use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterfaceFactory;
use Hawksama\ShopfinderGraphQL\Command\Shopfinder\SaveCommand;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save Notice controller action.
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Hawksama_ShopfinderGraphQL::management';

    public function __construct(
        Context $context,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly SaveCommand $saveCommand,
        private readonly ShopfinderInterfaceFactory $entityDataFactory
    )
    {
        parent::__construct($context);
    }

    /**
     * Save Notice Action.
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();

        try {
            /** @var ShopfinderInterface|DataObject $entityModel */
            $entityModel = $this->entityDataFactory->create();
            $entityModel->addData($params['general']);
            $this->saveCommand->execute($entityModel);
            $this->messageManager->addSuccessMessage(
                __('The Notice was saved successfully')
            );
            $this->dataPersistor->clear('entity');
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $this->dataPersistor->set('entity', $params);

            return $resultRedirect->setPath('*/*/edit', [
                ShopfinderInterface::SHOP_ID => $this->getRequest()->getParam(ShopfinderInterface::SHOP_ID)
            ]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
