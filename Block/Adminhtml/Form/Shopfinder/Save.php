<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Block\Adminhtml\Form\Shopfinder;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Save entity button.
 */
class Save extends GenericButton implements ButtonProviderInterface
{
	/**
	 * Retrieve Save button settings.
	 *
	 * @return array
	 */
	public function getButtonData(): array
	{
		return $this->wrapButtonSettings(
			__('Save')->getText(),
			'save primary',
			'',
			[
				'mage-init' => ['button' => ['event' => 'save']],
				'form-role' => 'save'
			],
			30
		);
	}
}
