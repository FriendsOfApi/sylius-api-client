<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Model\Customer;

use FAPI\Sylius\Model\CreatableFromArray;
use Nelmio\Alice\User;

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
     * @var UserCreated
     */
    private $user;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $emailCanonical;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $gender;

    /**
     * CustomerCreated constructor.
     *
     * @param int         $id
     * @param UserCreated $user
     * @param string      $email
     * @param string      $emailCanonical
     * @param string      $firstName
     * @param string      $lastName
     * @param string      $gender
     */
    private function __construct(
        int $id,
        UserCreated $user,
        string $email,
        string $emailCanonical,
        string $firstName,
        string $lastName,
        string $gender
    ) {
        $this->id = $id;
        if (-1 !== $user->getId()) {
            $this->user = $user;
        }
        $this->email = $email;
        $this->emailCanonical = $emailCanonical;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
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

        $user = UserCreated::createFromArray([]);
        if (isset($data['user'])) {
            $user = UserCreated::createFromArray($data['user']);
        }

        $email = '';
        if (isset($data['email'])) {
            $email = $data['email'];
        }

        $emailCanonical = '';
        if (isset($data['emailCanonical'])) {
            $emailCanonical = $data['emailCanonical'];
        }

        $firstName = '';
        if (isset($data['firstName'])) {
            $firstName = $data['firstName'];
        }

        $lastName = '';
        if (isset($data['lastName'])) {
            $lastName = $data['lastName'];
        }

        $gender = '';
        if (isset($data['gender'])) {
            $gender = $data['gender'];
        }

        return new self($id, $user, $email, $emailCanonical, $firstName, $lastName, $gender);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return UserCreated
     */
    public function getUser(): UserCreated
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getEmailCanonical(): string
    {
        return $this->emailCanonical;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }
}
