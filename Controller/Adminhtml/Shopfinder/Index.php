<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Controller\Adminhtml\Shopfinder;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Notice backend index (list) controller.
 */
class Index extends Action implements HttpGetActionInterface
{
	/**
	 * Authorization level of a basic admin session.
	 */
	public const ADMIN_RESOURCE = 'Hawksama_ShopfinderGraphQL::management';

	public function execute(): ResultInterface|ResponseInterface
	{
		$resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

		$resultPage->setActiveMenu('Hawksama_ShopfinderGraphQL::management');
		$resultPage->addBreadcrumb(__('Shopfinder'), __('Shopfinder'));
		$resultPage->addBreadcrumb(__('Manage Shopfinders'), __('Manage Shopfinder'));
		$resultPage->getConfig()->getTitle()->prepend(__('Shopfinder List'));

		return $resultPage;
	}
}
