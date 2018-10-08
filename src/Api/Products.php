<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api;

use FAPI\Sylius\Exception;
use FAPI\Sylius\Model\Product\ProductCollection;
use FAPI\Sylius\Model\Product\VariantCollection;
use FAPI\Sylius\Model\Product\Product;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class Products extends HttpApi
{
    public function get(string $productCode)
    {
        $response = $this->httpGet("/api/v1/products/{$productCode}");

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Product::class);
    }

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

        // Use any valid status code here
        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, ProductCollection::class);
    }

    /**
     * @param string $productCode
     * @param array  $params
     *
     * @return VariantCollection|ResponseInterface
     *
     * @throws Exception\DomainException
     */
    public function getVariants(string $productCode, array $params = [])
    {
        $response = $this->httpGet("/api/v1/products/{$productCode}/variants/", $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, VariantCollection::class);
    }
}
