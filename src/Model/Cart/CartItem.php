<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Model\Cart;

use FAPI\Sylius\Model\CreatableFromArray;
use FAPI\Sylius\Model\Product\Variant;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class CartItem implements CreatableFromArray
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $unitPrice;

    /**
     * @var int
     */
    private $total;

    /**
     * @var Variant
     */
    private $variant;

    /**
     * CartItem constructor.
     *
     * @param int          $id
     * @param int          $quantity
     * @param int          $unitPrice
     * @param int          $total
     * @param null|Variant $variant
     */
    private function __construct(
        int $id,
        int $quantity,
        int $unitPrice,
        int $total,
        Variant $variant
    ) {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->total = $total;
        if (null !== $variant) {
            $this->variant = $variant;
        }
    }

    /**
     * @param array $data
     *
     * @return CartItem
     */
    public static function createFromArray(array $data): self
    {
        $id = -1;
        if (isset($data['id'])) {
            $id = $data['id'];
        }

        $quantity = -1;
        if (isset($data['quantity'])) {
            $quantity = $data['quantity'];
        }

        $unitPrice = -1;
        if (isset($data['unitPrice'])) {
            $unitPrice = $data['unitPrice'];
        }

        $total = '';
        if (isset($data['total'])) {
            $total = $data['total'];
        }

        $variant = null;
        if (isset($data['variant'])) {
            $variant = Variant::createFromArray($data['variant']);
        }

        return new self($id, $quantity, $unitPrice, $total, $variant);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}
