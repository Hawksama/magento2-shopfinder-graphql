<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Mapper;

use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterfaceFactory;
use Hawksama\ShopfinderGraphQL\Model\ShopfinderModel;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of Notice entities to an array of data transfer objects.
 */
class ShopfinderDataMapper
{
	public function __construct(
		private readonly ShopfinderInterfaceFactory $entityDtoFactory
	) {
	}

	/**
	 * Map magento models to DTO array.
	 *
	 * @param AbstractCollection $collection
	 * @return array|ShopfinderInterface[]
	 */
	public function map(AbstractCollection $collection): array
	{
		$results = [];
		/** @var ShopfinderModel $item */
		foreach ($collection->getItems() as $item) {
			/** @var ShopfinderInterface|DataObject $entityDto */
			$entityDto = $this->entityDtoFactory->create();
			$entityDto->addData($item->getData());

			$results[] = $entityDto;
		}

		return $results;
	}
}
