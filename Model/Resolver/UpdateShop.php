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
use Magento\Framework\Exception\CouldNotSaveException;
use Hawksama\ShopfinderGraphQL\Command\Shopfinder\SaveCommand;
use Hawksama\ShopfinderGraphQL\Model\ShopfinderModelFactory;
use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterfaceFactory;
use Hawksama\ShopfinderGraphQL\Api\Data\ShopfinderInterface;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderResource;
use Psr\Log\LoggerInterface;

class UpdateShop implements ResolverInterface
{
    public function __construct(
        private readonly SaveCommand $saveCommand,
        private readonly ShopfinderModelFactory $modelFactory,
        private readonly ShopfinderInterfaceFactory $entityDataFactory,
        private readonly ShopfinderResource $resource,
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
        try {
            $input = $this->validateAndGetInput($args);

            // check if shop exists
            $existingModel = $this->modelFactory->create();
            $this->resource->load($existingModel, $input['shop_id'], ShopfinderInterface::SHOP_ID);

            if (!$existingModel->getId()) {
                throw new LocalizedException(
                    __('Shop with ID %1 does not exist.', $input['shop_id'])
                );
            }

            $mergedData = array_merge(
                $existingModel->getData(),
                $input
            );

            /** @var ShopfinderInterface $entityModel */
            $entityModel = $this->entityDataFactory->create();
            $entityModel->addData($mergedData);

            $this->saveCommand->execute($entityModel);

            return [
                'shop' => $entityModel->getData()
            ];

        } catch (CouldNotSaveException $e) {
            $this->logger->error('Failed to update shop: ' . $e->getMessage(), [
                'input' => $input ?? [],
                'exception' => $e
            ]);
            throw new LocalizedException(
                __('Could not update shop. Please try again later.')
            );
        } catch (LocalizedException $e) {
            $this->logger->warning('Validation error in shop update: ' . $e->getMessage(), [
                'input' => $input ?? []
            ]);
            throw $e;
        } catch (\Exception $e) {
            $this->logger->critical('Unexpected error in shop update: ' . $e->getMessage(), [
                'input' => $input ?? [],
                'exception' => $e
            ]);
            throw new LocalizedException(
                __('An unexpected error occurred. Please try again later.')
            );
        }
    }

    /**
     * Validate input data and return validated input
     *
     * @param array|null $args
     * @return array
     * @throws LocalizedException
     */
    private function validateAndGetInput(?array $args): array
    {
        if (!isset($args['input'])) {
            throw new LocalizedException(__('Input data is required'));
        }

        $input = $args['input'];

        if (!isset($input['shop_id'])) {
            throw new LocalizedException(__('Shop ID is required for updating a shop'));
        }

        // Validate identifier format if provided
        if (isset($input['identifier']) && !empty($input['identifier'])) {
            if (!preg_match('/^[a-z0-9_-]+$/', $input['identifier'])) {
                throw new LocalizedException(
                    __('Identifier can only contain lowercase letters, numbers, underscores and hyphens')
                );
            }
        }

        // Validate country code if provided
        if (isset($input['country']) && !empty($input['country'])) {
            if (strlen($input['country']) !== 2) {
                throw new LocalizedException(
                    __('Country must be a valid 2-letter ISO code')
                );
            }
            $input['country'] = strtoupper($input['country']);
        }

        return $input;
    }
}
