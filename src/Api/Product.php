<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api;

use FAPI\Sylius\Api\Product\Variant;
use FAPI\Sylius\Exception;
use FAPI\Sylius\Model\Product\Product as Model;
use FAPI\Sylius\Model\Product\ProductCollection;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class Product extends HttpApi
{
    public function variant(): Variant
    {
        return new Variant($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @throws Exception
     *
     * @return Model|ResponseInterface
     */
    public function get(string $productCode)
    {
        $response = $this->httpGet('/api/v1/products/'.$productCode);
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
     * {@link https://docs.sylius.com/en/1.3/api/products.html#creating-a-product}.
     *
     * @throws Exception
     *
     * @return Model|ResponseInterface
     */
    public function create(string $productCode, array $params = [])
    {
        $params['code'] = $productCode;
        $response = $this->httpPost('/api/v1/products/', $params);
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (201 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Model::class);
    }

    /**
     * Update a product partially.
     *
     * {@link https://docs.sylius.com/en/1.3/api/products.html#id14}
     *
     * @throws Exception
     *
     * @return void|ResponseInterface
     */
    public function update(string $productCode, array $params = [])
    {
        $response = $this->httpPatch('/api/v1/products/'.$productCode, $params);
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }

    /**
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
}
