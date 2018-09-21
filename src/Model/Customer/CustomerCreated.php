<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Model\Customer;

use FAPI\Sylius\Model\CreatableFromArray;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class CustomerCreated implements CreatableFromArray
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     */
    private function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param array $data
     *
     * @return CustomerCreated
     */
    public static function createFromArray(array $data): CustomerCreated
    {
        $id = -1;

        if (isset($data['id'])) {
            $id = $data['id'];
        }

        return new self($id);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
