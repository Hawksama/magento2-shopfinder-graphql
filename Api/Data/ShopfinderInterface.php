<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Api\Data;


interface ShopfinderInterface
{
    /**
     * String constants for property names
     */
    public const SHOP_ID = "shop_id";
    public const NAME = "name";
    public const IDENTIFIER = "identifier";
    public const COUNTRY = "country";

    /**
     * Getter for ShopId.
     *
     * @return int|null
     */
    public function getShopId(): ?int;

    /**
     * Setter for ShopId.
     *
     * @param int|null $shopId
     * @return void
     */
    public function setShopId(?int $shopId): void;

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $name
     * @return void
     */
    public function setName(?string $name): void;

    /**
     * Getter for Identifier.
     *
     * @return string|null
     */
    public function getIdentifier(): ?string;

    /**
     * Setter for Identifier.
     *
     * @param string|null $identifier
     * @return void
     */
    public function setIdentifier(?string $identifier): void;

    /**
     * Getter for Country.
     *
     * @return string|null
     */
    public function getCountry(): ?string;

    /**
     * Setter for Country.
     *
     * @param string|null $country
     * @return void
     */
    public function setCountry(?string $country): void;
}
