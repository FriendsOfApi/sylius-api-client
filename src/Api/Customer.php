<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api;

use FAPI\Sylius\Exception;
use FAPI\Sylius\Exception\Domain as DomainExceptions;
use FAPI\Sylius\Exception\InvalidArgumentException;
use FAPI\Sylius\Model\Customer\Customer as Model;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class Customer extends HttpApi
{
    /**
     * @param string $message
     * @param string $location
     * @param array  $hashtags
     *
     * @throws Exception
     *
     * @return Customer|ResponseInterface
     */
    public function create(string $email, string $firstName, string $lastName, string $gender, array $optionalParams = [])
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Email cannot be empty');
        }

        if (empty($firstName)) {
            throw new InvalidArgumentException('First name cannot be empty');
        }

        if (empty($lastName)) {
            throw new InvalidArgumentException('Last name cannot be empty');
        }

        if (empty($gender)) {
            throw new InvalidArgumentException('Gender cannot be empty');
        }

        $params = array_merge([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'gender' => $gender,
        ], $optionalParams);

        $response = $this->httpPost('/api/v1/customers/', $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (201 !== $response->getStatusCode()) {
            switch ($response->getStatusCode()) {
                case 400:
                    throw new DomainExceptions\ValidationException();
                    break;
                default:
                    $this->handleErrors($response);

                    break;
            }
        }

        return $this->hydrator->hydrate($response, Model::class);
    }
}
