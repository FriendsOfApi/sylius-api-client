<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Model\Cart;

use FAPI\Sylius\Model\CreatableFromArray;
use FAPI\Sylius\Model\Customer\CustomerCreated;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class CartCreated implements CreatableFromArray
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var CustomerCreated
     */
    private $customer;

    /**
     * @var string
     */
    private $currencyCode;

    /**
     * @var string
     */
    private $localeCode;

    /**
     * @var string
     */
    private $checkoutState;

    /**
     * CartCreated constructor.
     *
     * @param int             $id
     * @param CustomerCreated $customer
     * @param string          $currencyCode
     * @param string          $localeCode
     * @param string          $checkoutState
     */
    private function __construct(
        int $id,
        CustomerCreated $customer,
        string $currencyCode,
        string $localeCode,
        string $checkoutState
    ) {
        $this->id = $id;
        $this->customer = $customer;
        $this->currencyCode = $currencyCode;
        $this->localeCode = $localeCode;
        $this->checkoutState = $checkoutState;
    }

    /**
     * @param array $data
     *
     * @return CustomerCreated
     */
    public static function createFromArray(array $data): self
    {
        $id = -1;
        if (isset($data['id'])) {
            $id = $data['id'];
        }

        $customer = CustomerCreated::createFromArray([]);
        if (isset($data['customer'])) {
            $customer = CustomerCreated::createFromArray($data['customer']);
        }

        $currencyCode = '';
        if (isset($data['currencyCode'])) {
            $currencyCode = $data['currencyCode'];
        }

        $localeCode = '';
        if (isset($data['localeCode'])) {
            $localeCode = $data['localeCode'];
        }

        $checkoutState = '';
        if (isset($data['checkoutState'])) {
            $checkoutState = $data['checkoutState'];
        }

        return new self($id, $customer, $currencyCode, $localeCode, $checkoutState);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return CustomerCreated
     */
    public function getCustomer(): CustomerCreated
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @return string
     */
    public function getLocaleCode(): string
    {
        return $this->localeCode;
    }

    /**
     * @return string
     */
    public function getCheckoutState(): string
    {
        return $this->checkoutState;
    }
}
