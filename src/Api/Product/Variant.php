<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api\Product;

use FAPI\Sylius\Exception;
use FAPI\Sylius\Model\Product\Product as Model;
use FAPI\Sylius\Model\Product\ProductCollection;
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
