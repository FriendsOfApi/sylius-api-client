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
final class ShipmentCollection implements CreatableFromArray
{
    /**
     * @var Shipment[]
     */
    private $shipments;

    /**
     * Shipment constructor.
     *
     * @param array|Shipment[] $shipments
     */
    private function __construct(array $shipments)
    {
        $this->shipments = $shipments;
    }

    /**
     * @return Shipment
     */
    public static function createFromArray(array $data): self
    {
        $shipments = [];
        if (!empty($data)) {
            foreach ($data['shipments'] as $shipment) {
                $shipments[] = Shipment::createFromArray($shipment);
            }
        }

        return new self($shipments);
    }

    /**
     * @return Shipment[]
     */
    public function getShipments(): array
    {
        return $this->shipments;
    }
}
