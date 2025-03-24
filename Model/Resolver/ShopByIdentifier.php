<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderModel\ShopfinderCollectionFactory as CollectionFactory;

class ShopByIdentifier implements ResolverInterface
{
    public function __construct(
        private readonly CollectionFactory $collectionFactory
    ) {
    }

    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $identifier = $args['identifier'];
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('identifier', $identifier);
        $shop = $collection->getFirstItem();

        if (!$shop->getId()) {
            throw new NoSuchEntityException(__('Shop with identifier "%1" does not exist.', $identifier));
        }

        return $shop->getData();
    }
}
