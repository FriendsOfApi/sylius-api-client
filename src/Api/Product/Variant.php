<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api\Product;

use FAPI\Sylius\Api\HttpApi;
use FAPI\Sylius\Exception;
use FAPI\Sylius\Model\Product\Variant as Model;
use FAPI\Sylius\Model\Product\VariantCollection;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Variant extends HttpApi
{
    /**
     * @throws Exception\DomainException
     *
     * @return ResponseInterface|VariantCollection
     */
    public function getAll(string $productCode, array $params = [])
    {
        $response = $this->httpGet(\sprintf('/api/v1/products/%s/variants/', $productCode), $params);
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, VariantCollection::class);
    }

    /**
     * {@link https://docs.sylius.com/en/1.3/api/product_variants.html#getting-a-single-product-variant}.
     *
     * @throws Exception
     *
     * @return Model|ResponseInterface
     */
    public function get(string $productCode, string $code)
    {
        $response = $this->httpGet(sprintf('/api/v1/products/%s/variants/%s', $productCode, $code));
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
     * {@link https://docs.sylius.com/en/1.3/api/product_variants.html#creating-a-product-variant}.
     *
     * @throws Exception
     *
     * @return Model|ResponseInterface
     */
    public function create(string $productCode, string $code, array $params = [])
    {
        $params['code'] = $code;
        $response = $this->httpPost(sprintf('/api/v1/products/%s/variants/', $productCode), $params);
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
     * {@link https://docs.sylius.com/en/1.3/api/product_variants.html#updating-product-variant}
     *
     * @throws Exception
     *
     * @return void|ResponseInterface
     */
    public function update(string $productCode, string $code, array $params = [])
    {
        $response = $this->httpPut(sprintf('/api/v1/products/%s/variants/%s', $productCode, $code), $params);
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }

    /**
     * {@link https://docs.sylius.com/en/1.3/api/product_variants.html#deleting-a-product-variant}.
     *
     * @throws Exception
     *
     * @return void|ResponseInterface
     */
    public function delete(string $productCode, string $code)
    {
        $response = $this->httpDelete(sprintf('/api/v1/products/%s/variants/%s', $productCode, $code));
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }
}
