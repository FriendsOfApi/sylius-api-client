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
use FAPI\Sylius\Model\Cart\Cart as Model;
use FAPI\Sylius\Model\Cart\CartItem;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class Cart extends HttpApi
{
    /**
     * @throws Exception
     *
     * @return Model|ResponseInterface
     */
    public function get(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpGet('/api/v1/carts/'.$id);
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Model::class);
    }

    /**
     * @throws Exception
     *
     * @return Model|ResponseInterface
     */
    public function create(string $customer, string $channel, string $localeCode, array $params = [])
    {
        if (empty($customer)) {
            throw new InvalidArgumentException('Customers field cannot be empty');
        }

        if (empty($channel)) {
            throw new InvalidArgumentException('Channel cannot be empty');
        }

        if (empty($localeCode)) {
            throw new InvalidArgumentException('Locale code cannot be empty');
        }

        $params['customer'] = $customer;
        $params['channel'] = $channel;
        $params['localeCode'] = $localeCode;

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

        return $this->hydrator->hydrate($response, Model::class);
    }

    /**
     * @throws Exception
     *
     * @return CartItem|ResponseInterface
     */
    public function addItem(int $cartId, string $variant, int $quantity)
    {
        if (empty($cartId)) {
            throw new InvalidArgumentException('Cart id field cannot be empty');
        }

        if (empty($variant)) {
            throw new InvalidArgumentException('variant cannot be empty');
        }

        if (empty($quantity)) {
            throw new InvalidArgumentException('quantity cannot be empty');
        }

        $params = [
            'variant' => $variant,
            'quantity' => $quantity,
        ];

        $response = $this->httpPost(\sprintf('/api/v1/carts/%d/items/', $cartId), $params);
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

        return $this->hydrator->hydrate($response, CartItem::class);
    }
}
