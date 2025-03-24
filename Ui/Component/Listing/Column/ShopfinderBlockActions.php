<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Ui\Component\Listing\Column;

use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class to build edit and delete link for each item.
 */
class ShopfinderBlockActions extends Column
{
	private const ENTITY_NAME = 'Shopfinder';

	private const EDIT_URL_PATH = 'hawksama/shopfinder/edit';
	private const DELETE_URL_PATH = 'hawksama/shopfinder/delete';

	/**
	 * @param ContextInterface $context
	 * @param UiComponentFactory $uiComponentFactory
	 * @param UrlInterface $urlBuilder
	 * @param array $components
	 * @param array $data
	 */
	public function __construct(
		ContextInterface   $context,
		UiComponentFactory $uiComponentFactory,
		private readonly UrlInterface $urlBuilder,
		array $components = [],
		array $data = []
	)
	{
		parent::__construct(
			$context,
			$uiComponentFactory,
			$components,
			$data
		);
	}

	/**
	 * Prepare data source.
	 */
	public function prepareDataSource(array $dataSource): array
	{
		if (isset($dataSource['data']['items'])) {
			foreach ($dataSource['data']['items'] as &$item) {
				if (isset($item[ShopfinderInterface::SHOP_ID])) {
					$entityName = static::ENTITY_NAME;
					$urlData = [ShopfinderInterface::SHOP_ID => $item[ShopfinderInterface::SHOP_ID]];

					$editUrl = $this->urlBuilder->getUrl(static::EDIT_URL_PATH, $urlData);
					$deleteUrl = $this->urlBuilder->getUrl(static::DELETE_URL_PATH, $urlData);

					$item[$this->getData('name')] = [
						'edit' => $this->getActionData($editUrl, (string)__('Edit')),
						'delete' => $this->getActionData(
							$deleteUrl,
							(string)__('Delete'),
							(string)__('Delete %1', $entityName),
							(string)__('Are you sure you want to delete a %1 record?', $entityName)
						)
					];
				}
			}
		}

		return $dataSource;
	}

	/**
	 * Get action link data array.
	 */
	private function getActionData(
		string  $url,
		string  $label,
		?string $dialogTitle = null,
		?string $dialogMessage = null
	): array
	{
		$data = [
			'href' => $url,
			'label' => $label,
			'post' => true,
			'__disableTmpl' => true
		];

		if ($dialogTitle && $dialogMessage) {
			$data['confirm'] = [
				'title' => $dialogTitle,
				'message' => $dialogMessage
			];
		}

		return $data;
	}
}
