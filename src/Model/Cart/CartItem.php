<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Model\Cart;

use FAPI\Sylius\Model\CreatableFromArray;
use FAPI\Sylius\Model\Customer\Customer;

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

    //TODO: Add more of the fields in create cartitem response.

    private function __construct(
        int $id,
        int $quantity,
        int $unitPrice,
        int $total
    ) {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->total = $total;
    }

    /**
     * @param array $data
     *
     * @return Customer
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

        return new self($id, $quantity, $unitPrice, $total);
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
