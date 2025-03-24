<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Model\ResourceModel;

use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ShopfinderResource extends AbstractDb
{
	/**
	 * @var string
	 */
	protected $_eventPrefix = 'hawksama_shopfinder_resource_model';

	/**
	 * Initialize resource model.
	 */
	protected function _construct()
	{
		$this->_init('hawksama_shopfinder', ShopfinderInterface::SHOP_ID);
		$this->_useIsObjectNew = true;
	}
}
