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
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class DeleteShop implements ResolverInterface
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $this->logger->warning('Attempted shop deletion via GraphQL', [
            'shop_id' => $args['shop_id'] ?? null,
            'user_info' => $context->getUserId() ?? 'anonymous'
        ]);

        throw new LocalizedException(
            __('Shop deletion is not allowed via GraphQL API. Please use the admin interface.')
        );
    }
}
