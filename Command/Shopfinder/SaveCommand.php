<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Command\Shopfinder;

use Exception;
use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Hawksama\ShopfinderGraphQL\Model\ShopfinderModel;
use Hawksama\ShopfinderGraphQL\Model\ShopfinderModelFactory;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderResource;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

/**
 * Save Shop Command.
 */
class SaveCommand
{
	public function __construct(
		private readonly LoggerInterface $logger,
        private readonly ShopfinderModelFactory $modelFactory,
        private readonly ShopfinderResource $resource
	) {
	}

	/**
	 * Save Shop.
	 *
	 * @param ShopfinderInterface $notice
	 * @return int
	 * @throws CouldNotSaveException
	 */
	public function execute(ShopfinderInterface $notice): int
	{
		try {
			/** @var ShopfinderModel $model */
			$model = $this->modelFactory->create();
			$model->addData($notice->getData());
			$model->setHasDataChanges(true);

			if (!$model->getData(ShopfinderInterface::SHOP_ID)) {
				$model->isObjectNew(true);
			}
			$this->resource->save($model);
		} catch (Exception $exception) {
			$this->logger->error(
				__('Could not save Shop. Original message: {message}'),
				[
					'message' => $exception->getMessage(),
					'exception' => $exception
				]
			);
			throw new CouldNotSaveException(__('Could not save Shop.'));
		}

		return (int)$model->getData(ShopfinderInterface::SHOP_ID);
	}
}
