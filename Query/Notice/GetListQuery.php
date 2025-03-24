<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Query\Notice;

use Hawksama\ShopfinderGraphQL\Mapper\ShopfinderDataMapper;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderModel\ShopfinderCollection;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderModel\ShopfinderCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

/**
 * Get Notice list by search criteria query.
 */
class GetListQuery
{
	public function __construct(
		private readonly CollectionProcessorInterface  $collectionProcessor,
		private readonly ShopfinderCollectionFactory       $entityCollectionFactory,
		private readonly ShopfinderDataMapper          $entityDataMapper,
		private readonly SearchCriteriaBuilder         $searchCriteriaBuilder,
		private readonly SearchResultsInterfaceFactory $searchResultFactory
	) {
	}

	/**
	 * Get Notice list by search criteria.
	 */
	public function execute(?SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
	{
		/** @var ShopfinderCollection $collection */
		$collection = $this->entityCollectionFactory->create();

		if ($searchCriteria === null) {
			$searchCriteria = $this->searchCriteriaBuilder->create();
		} else {
			$this->collectionProcessor->process($searchCriteria, $collection);
		}

		$entityDataObjects = $this->entityDataMapper->map($collection);

		/** @var SearchResultsInterface $searchResult */
		$searchResult = $this->searchResultFactory->create();
		$searchResult->setItems($entityDataObjects);
		$searchResult->setTotalCount($collection->getSize());
		$searchResult->setSearchCriteria($searchCriteria);

		return $searchResult;
	}
}
