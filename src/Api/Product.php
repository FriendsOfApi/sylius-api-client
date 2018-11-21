<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api;

use FAPI\Sylius\Exception;
use FAPI\Sylius\Model\Product\Product as Model;
use FAPI\Sylius\Model\Product\ProductCollection;
use FAPI\Sylius\Model\Product\VariantCollection;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class Product extends HttpApi
{
    /**
     * @throws Exception
     * @reeturn Model|ResponseInterface
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
     * @throws Exception
     * @reeturn Model|ResponseInterface
     */
    public function create(string $productCode)
    {
        $response = $this->httpPost('/api/v1/products/', ['code'=>$productCode]);
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
     * @throws Exception\DomainException
     *
     * @return ResponseInterface|VariantCollection
     */
    public function getVariants(string $productCode, array $params = [])
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
}
