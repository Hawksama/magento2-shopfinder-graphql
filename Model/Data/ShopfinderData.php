<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Model\Data;

use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Magento\Framework\DataObject;

class ShopfinderData extends DataObject implements ShopfinderInterface
{
    /**
     * Getter for ShopId.
     *
     * @return int|null
     */
    public function getShopId(): ?int
    {
        return $this->getData(self::SHOP_ID) === null ? null
            : (int)$this->getData(self::SHOP_ID);
    }

    /**
     * Setter for ShopId.
     *
     * @param int|null $shopId
     * @return void
     */
    public function setShopId(?int $shopId): void
    {
        $this->setData(self::SHOP_ID, $shopId);
    }

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Setter for Name.
     *
     * @param string|null $name
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * Getter for Identifier.
     *
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * Setter for Identifier.
     *
     * @param string|null $identifier
     * @return void
     */
    public function setIdentifier(?string $identifier): void
    {
        $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Getter for Country.
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * Setter for Country.
     *
     * @param string|null $country
     * @return void
     */
    public function setCountry(?string $country): void
    {
        $this->setData(self::COUNTRY, $country);
    }
}
