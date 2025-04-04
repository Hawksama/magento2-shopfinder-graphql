<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Ui\DataProvider;

use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Hawksama\ShopfinderGraphQL\Query\Notice\GetListQuery;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\SearchResultFactory;

/**
 * DataProvider component.
 */
class ShopfinderDataProvider extends DataProvider
{
	/**
	 * @var array
	 */
	private $loadedData = [];

	public function __construct(
		$name,
		$primaryFieldName,
		$requestFieldName,
		ReportingInterface $reporting,
		SearchCriteriaBuilder $searchCriteriaBuilder,
		RequestInterface $request,
		FilterBuilder $filterBuilder,
		private readonly GetListQuery $getListQuery,
        private readonly SearchResultFactory $searchResultFactory,
		array $meta = [],
		array $data = []
	)
	{
		parent::__construct(
			$name,
			$primaryFieldName,
			$requestFieldName,
			$reporting,
			$searchCriteriaBuilder,
			$request,
			$filterBuilder,
			$meta,
			$data
		);
	}

	/**
	 * Returns searching result.
	 */
	public function getSearchResult(): SearchResultInterface
	{
		$searchCriteria = $this->getSearchCriteria();
		$result = $this->getListQuery->execute($searchCriteria);

		return $this->searchResultFactory->create(
			$result->getItems(),
			$result->getTotalCount(),
			$searchCriteria,
			ShopfinderInterface::SHOP_ID
		);
	}

	/**
	 * Get data.
	 *
	 * @return array
	 */
	public function getData(): array
	{
		if ($this->loadedData) {
			return $this->loadedData;
		}
		$this->loadedData = parent::getData();
		$itemsById = [];

		foreach ($this->loadedData['items'] as $item) {
			$itemsById[(int)$item[ShopfinderInterface::SHOP_ID]] = $item;
		}

		if ($id = $this->request->getParam(ShopfinderInterface::SHOP_ID)) {
			$this->loadedData['entity'] = $itemsById[(int)$id];
		}

		return $this->loadedData;
	}
}
