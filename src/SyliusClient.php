<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius;

use FAPI\Sylius\Api\Products;
use FAPI\Sylius\Hydrator\Hydrator;
use FAPI\Sylius\Hydrator\ModelHydrator;
use Http\Client\HttpClient;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class SyliusClient
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * The constructor accepts already configured HTTP clients.
     * Use the configure method to pass a configuration to the Client and create an HTTP Client.
     *
     * @param HttpClient          $httpClient
     * @param null|Hydrator       $hydrator
     * @param null|RequestBuilder $requestBuilder
     */
    public function __construct(
        HttpClient $httpClient,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ) {
        $this->httpClient = $httpClient;
        $this->hydrator = $hydrator ?: new ModelHydrator();
        $this->requestBuilder = $requestBuilder ?: new RequestBuilder();
    }

    /**
     * @param HttpClientConfigurator $httpClientConfigurator
     * @param null|Hydrator          $hydrator
     * @param null|RequestBuilder    $requestBuilder
     *
     * @return SyliusClient
     */
    public static function configure(
        HttpClientConfigurator $httpClientConfigurator,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ): self {
        $httpClient = $httpClientConfigurator->createConfiguredClient();

        return new self($httpClient, $hydrator, $requestBuilder);
    }

    /**
     * @param string $apiKey
     *
     * @return SyliusClient
     */
    public static function create(string $apiKey, string $endPoint): self
    {
        $httpClientConfigurator = (new HttpClientConfigurator())
            ->setApiKey($apiKey)
            ->setEndpoint($endPoint);

        return self::configure($httpClientConfigurator);
    }

    /**
     * @return Api\Customers
     */
    public function customers(): Api\Customers
    {
        return new Api\Customers($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\Carts
     */
    public function carts(): Api\Carts
    {
        return new Api\Carts($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\Products
     */
    public function products(): Api\Products
    {
        return new Api\Products($this->httpClient, $this->hydrator, $this->requestBuilder);

    }

    public function checkouts(): Api\Checkouts
    {
        return new Api\Checkouts($this->httpClient, $this->hydrator, $this->requestBuilder);
    }
}
