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
final class PaymentCollection implements CreatableFromArray
{
    /**
     * @var Payment[]
     */
    private $payments;

    /**
     * PaymentCollection constructor.
     *
     * @param array|Shipment[] $payments
     */
    private function __construct(array $payments)
    {
        $this->payments = $payments;
    }

    /**
     * @return Shipment
     */
    public static function createFromArray(array $data): self
    {
        $payments = [];
        if (!empty($data)) {
            foreach ($data['payments'] as $payment) {
                $payments[] = Payment::createFromArray($payment);
            }
        }

        return new self($payments);
    }

    /**
     * @return Payment[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }
}
