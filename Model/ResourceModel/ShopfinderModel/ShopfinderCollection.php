<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderModel;

use Hawksama\ShopfinderGraphQL\Model\ShopfinderModel;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class ShopfinderCollection extends AbstractCollection
{
	/**
	 * @var string
	 */
	protected $_eventPrefix = 'hawksama_shopfinder_collection';

	/**
	 * Initialize collection model.
	 */
	protected function _construct()
	{
		$this->_init(ShopfinderModel::class, ShopfinderResource::class);
	}
}
