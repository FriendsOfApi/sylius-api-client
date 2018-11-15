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
final class Payment implements CreatableFromArray
{
    /**
     * @var PaymentMethod[]
     */
    private $methods;

    /**
     * Payment constructor.
     *
     * @param array|PaymentMethod[] $methods
     */
    private function __construct(array $methods)
    {
        $this->methods = $methods;
    }

    /**
     * @return Payment
     */
    public static function createFromArray(array $data): self
    {
        $methods = [];
        foreach ($data['methods'] as $method) {
            $methods[] = PaymentMethod::createFromArray($method);
        }

        return new self($methods);
    }

    /**
     * @return PaymentMethod[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
