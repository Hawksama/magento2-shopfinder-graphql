<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Model\Source;

use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Country implements OptionSourceInterface
{
    /**
     * Constructor
     *
     * @param CountryCollectionFactory $countryCollectionFactory
     */
    public function __construct(
        private readonly CountryCollectionFactory $countryCollectionFactory
    ) {
    }

    /**
     * Get country options array
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $countryCollection = $this->countryCollectionFactory->create()
            ->loadByStore();

        $options = $countryCollection->toOptionArray(false);

        usort($options, function ($a, $b) {
            return strcmp($a['label'], $b['label']);
        });

        return $options;
    }
}
