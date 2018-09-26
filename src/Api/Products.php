<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api;

use FAPI\Sylius\Exception;
use FAPI\Sylius\Model\Product\ProductCollection;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class Products extends HttpApi
{
    /**
     * @param array $params
     *
     * @throws Exception\DomainException
     *
     * @return ProductCollection|ResponseInterface
     */
    public function getAll(array $params = [])
    {
        $response = $this->httpGet('/api/v1/products/', $params);

        if (!$this->hydrator) {
            return $response;
        }

        $body = $response->getBody()->__toString();
        // Use any valid status code here
        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, ProductCollection::class);
    }
}
