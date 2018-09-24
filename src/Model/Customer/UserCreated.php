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
final class UserCreated implements CreatableFromArray
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string[]
     */
    private $roles;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * UserCreated constructor.
     * @param int $id
     * @param string $username
     * @param string[] $roles
     * @param bool $enabled
     */
    private function __construct(int $id, string $username, $roles, bool $enabled)
    {
        $this->id = $id;
        $this->username = $username;
        $this->roles = $roles;
        $this->enabled = $enabled;
    }

    /**
     * @param array $data
     *
     * @return UserCreated
     */
    public static function createFromArray(array $data): UserCreated
    {
        $id = -1;

        if (isset($data['id'])) {
            $id = $data['id'];
        }

        $username = "";
        if (isset($data['username'])) {
            $username = $data['username'];
        }

        $roles = [];
        if (isset($data['roles'])) {
            $roles = $data['roles'];
        }

        $enabled = false;
        if (isset($data['enabled'])) {
            $enabled = $data['enabled'];
        }

        return new self($id, $username, $roles, $enabled);
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
