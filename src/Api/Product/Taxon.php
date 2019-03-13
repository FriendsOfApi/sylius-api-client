<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api\Product;

use FAPI\Sylius\Api\HttpApi;
use FAPI\Sylius\Exception;
use FAPI\Sylius\Model\Product\Taxon as Model;
use FAPI\Sylius\Model\Product\TaxonCollection as ModelCollection;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Radoje Albijanic <radoje.albijanic@gmail.com>
 */
final class Taxon extends HttpApi
{
    /**
     * {@link https://docs.sylius.com/en/1.4/api/taxons.html#collection-of-taxons}.
     *
     * @throws Exception\DomainException
     *
     * @return ResponseInterface|ModelCollection
     */
    public function getAll(array $params = [])
    {
        $response = $this->httpGet('/api/v1/taxons', $params);
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, ModelCollection::class);
    }

    /**
     * {@link https://docs.sylius.com/en/1.4/api/taxons.html#getting-a-single-taxon}.
     *
     * @throws Exception
     *
     * @return Model|ResponseInterface
     */
    public function get(string $code)
    {
        $response = $this->httpGet(\sprintf('/api/v1/taxons/%s', $code));
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
     * {@link https://docs.sylius.com/en/1.4/api/taxons.html#creating-a-taxon}.
     *
     * @throws Exception
     *
     * @return Model|ResponseInterface
     */
    public function create(string $code, array $params = [])
    {
        $params = $this->validateAndGetParams($code, $params);
        $response = $this->httpPost('/api/v1/taxons/', $params);
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
     * Update a taxon partially.
     *
     * {@link https://docs.sylius.com/en/1.4/api/taxons.html#updating-taxon}
     *
     * @throws Exception
     *
     * @return ResponseInterface|void
     */
    public function update(string $code, array $params = [])
    {
        $response = $this->httpPatch(\sprintf('/api/v1/taxons/%s', $code), $params);
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }

    /**
     * {@link https://docs.sylius.com/en/1.4/api/taxons.html#deleting-a-taxon}.
     *
     * @throws Exception
     *
     * @return ResponseInterface|void
     */
    public function delete(string $code)
    {
        $response = $this->httpDelete(\sprintf('/api/v1/taxons/%s', $code));
        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }

    private function validateAndGetParams(string $code, array $optionalParams): array
    {
        if (empty($code)) {
            throw new InvalidArgumentException('Code cannot be empty');
        }

        $params = \array_merge([
            'code' => $code,
        ], $optionalParams);

        return $params;
    }
}
