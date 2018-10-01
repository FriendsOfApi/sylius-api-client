<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Model\Checkout;

use FAPI\Sylius\Model\CreatableFromArray;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class ShipmentMethod implements CreatableFromArray
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $price;

    /**
     * ShipmentMethod constructor.
     *
     * @param int    $id
     * @param string $code
     * @param string $name
     * @param string $description
     * @param int    $price
     */
    private function __construct(
        int $id,
        string $code,
        string $name,
        string $description,
        int $price
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    /**
     * @param array $data
     *
     * @return ShipmentMethod
     */
    public static function createFromArray(array $data): self
    {
        $id = -1;
        if (isset($data['id'])) {
            $id = $data['id'];
        }

        $code = '';
        if (isset($data['code'])) {
            $code = $data['code'];
        }

        $name = '';
        if (isset($data['name'])) {
            $name = $data['name'];
        }

        $description = '';
        if (isset($data['description'])) {
            $description = $data['description'];
        }

        $price = -1;
        if (isset($data['price'])) {
            $price = $data['price'];
        }

        return new self($id, $code, $name, $description, $price);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }
}
