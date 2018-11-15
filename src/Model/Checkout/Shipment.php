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
final class Shipment implements CreatableFromArray
{
    /**
     * @var ShipmentMethod[]
     */
    private $methods;

    /**
     * Shipment constructor.
     *
     * @param array|ShipmentMethod[] $methods
     */
    private function __construct(array $methods)
    {
        $this->methods = $methods;
    }

    /**
     * @return Shipment
     */
    public static function createFromArray(array $data): self
    {
        $methods = [];
        foreach ($data['methods'] as $method) {
            $methods[] = ShipmentMethod::createFromArray($method);
        }

        return new self($methods);
    }

    /**
     * @return ShipmentMethod[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
