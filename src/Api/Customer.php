<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Boilerplate\Api;

use FAPI\Boilerplate\Exception;
use FAPI\Boilerplate\Exception\Domain as DomainExceptions;
use FAPI\Boilerplate\Exception\InvalidArgumentException;
use FAPI\Boilerplate\Model\Customer\CustomerCreated;
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
     * @return CustomerCreated|ResponseInterface
     *
     * @throws Exception
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
            'mail' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'gender' => $gender,
        ], $optionalParams);

        $response = $this->httpPost('/api/v1/customers', $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 201) {
            switch ($response->getStatusCode()) {
                case 400:
                    throw new DomainExceptions\ValidationException();
                    break;

                default:
                    $this->handleErrors($response);
                    break;
            }
        }

        return $this->hydrator->hydrate($response, CustomerCreated::class);
    }
}
