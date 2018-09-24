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
use FAPI\Sylius\Model\Product\ProductCollection;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class Products extends HttpApi
{
    /**
     * @param array $params
     * @return ProductCollection|ResponseInterface
     * @throws Exception\DomainException
     */
    public function getAll(array $params = [])
    {
        $response = $this->httpGet('/api/v1/products/', $params);

        if (!$this->hydrator) {
            return $response;
        }

        $body = $response->getBody()->__toString();
        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, ProductCollection::class);
    }
}
