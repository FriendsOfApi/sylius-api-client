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
use FAPI\Sylius\Model\Cart\CartCreated;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class Cart extends HttpApi
{
    /**
     * @param string $message
     * @param string $location
     * @param array  $hashtags
     *
     * @throws Exception
     *
     * @return CartCreated|ResponseInterface
     */
    public function create(string $customer, string $channel, string $localeCode)
    {
        if (empty($customer)) {
            throw new InvalidArgumentException('Customer field cannot be empty');
        }

        if (empty($channel)) {
            throw new InvalidArgumentException('Channel cannot be empty');
        }

        if (empty($localeCode)) {
            throw new InvalidArgumentException('Locale code cannot be empty');
        }

        $params = [
            'customer' => $customer,
            'channel' => $channel,
            'localeCode' => $localeCode,
        ];

        $response = $this->httpPost('/api/v1/carts/', $params);

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

        return $this->hydrator->hydrate($response, CartCreated::class);
    }
}
