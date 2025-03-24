<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Model;

use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderResource;
use Magento\Framework\Model\AbstractModel;

class ShopfinderModel extends AbstractModel
{
	/**
	 * @var string
	 */
	protected $_eventPrefix = 'hawksama_shopfinder_model';

	/**
	 * Initialize magento model.
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(ShopfinderResource::class);
	}
}
