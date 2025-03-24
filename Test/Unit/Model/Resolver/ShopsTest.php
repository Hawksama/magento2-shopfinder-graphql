<?php
declare(strict_types=1);

namespace Hawksama\ShopfinderGraphQL\Test\Unit\Model\Resolver;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Hawksama\ShopfinderGraphQL\Model\Resolver\Shops;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderModel\ShopfinderCollectionFactory as CollectionFactory;
use Hawksama\ShopfinderGraphQL\Model\ResourceModel\ShopfinderModel\ShopfinderCollection as Collection;

class ShopsTest extends TestCase
{
    /**
     * @var CollectionFactory|MockObject
     */
    private $collectionFactoryMock;

    /**
     * @var Collection|MockObject
     */
    private $collectionMock;

    /**
     * @var Shops
     */
    private $resolver;

    /**
     * @var Field|MockObject
     */
    private $fieldMock;

    /**
     * @var ResolveInfo|MockObject
     */
    private $resolveInfoMock;

    protected function setUp(): void
    {
        $this->collectionFactoryMock = $this->createMock(CollectionFactory::class);
        $this->collectionMock = $this->createMock(Collection::class);
        $this->fieldMock = $this->createMock(Field::class);
        $this->resolveInfoMock = $this->createMock(ResolveInfo::class);

        $this->resolver = new Shops(
            $this->collectionFactoryMock
        );
    }

    /**
     * @test
     */
    public function testResolveReturnsShopData(): void
    {
        $expectedData = [
            [
                'shop_id' => 1,
                'name' => 'Shop in Australia',
                'identifier' => 'shop_in_australia',
                'country' => 'AU'
            ],
            [
                'shop_id' => 2,
                'name' => 'Shop in Romania',
                'identifier' => 'shop_in_romania',
                'country' => 'RO'
            ]
        ];

        $this->collectionFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collectionMock);

        $this->collectionMock
            ->expects($this->once())
            ->method('getData')
            ->willReturn($expectedData);

        $result = $this->resolver->resolve(
            $this->fieldMock,
            null,
            $this->resolveInfoMock,
            [],
            []
        );

        $this->assertEquals($expectedData, $result);
    }

    /**
     * @test
     */
    public function testResolveReturnsEmptyArrayWhenNoShops(): void
    {
        $this->collectionFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collectionMock);

        $this->collectionMock
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $result = $this->resolver->resolve(
            $this->fieldMock,
            null,
            $this->resolveInfoMock,
            [],
            []
        );

        $this->assertEmpty($result);
        $this->assertIsArray($result);
    }
}
