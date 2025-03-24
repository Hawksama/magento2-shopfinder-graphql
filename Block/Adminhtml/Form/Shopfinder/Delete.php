<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Block\Adminhtml\Form\Shopfinder;

use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Delete entity button.
 */
class Delete extends GenericButton implements ButtonProviderInterface
{
	/**
	 * Retrieve Delete button settings.
	 *
	 * @return array
	 */
	public function getButtonData(): array
	{
		if (!$this->getNoticeId()) {
			return [];
		}

		return $this->wrapButtonSettings(
			__('Delete')->getText(),
			'delete',
			sprintf("deleteConfirm('%s', '%s')",
				__('Are you sure you want to delete this notice?'),
				$this->getUrl(
					'*/*/delete',
					[ShopfinderInterface::SHOP_ID => $this->getNoticeId()]
				)
			),
			[],
			20
		);
	}
}
