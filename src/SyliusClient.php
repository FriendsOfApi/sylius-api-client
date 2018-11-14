<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius;

use FAPI\Sylius\Api\Products;
use FAPI\Sylius\Http\AuthenticationPlugin;
use FAPI\Sylius\Http\ClientConfigurator;
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
     * @var ClientConfigurator
     */
    private $clientConfigurator;

    /**
     * @var string|null
     */
    private $clientId;

    /**
     * @var string|null
     */
    private $clientSecret;

    /**
     * @var AuthenticationPlugin|null
     */
    private $authenticationPlugin;

    /**
     * The constructor accepts already configured HTTP clients.
     * Use the configure method to pass a configuration to the Client and create an HTTP Client.
     */
    public function __construct(
        ClientConfigurator $clientConfigurator,
        string $clientId,
        string $clientSecret,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ) {
        $this->clientConfigurator = $clientConfigurator;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->hydrator = $hydrator ?: new ModelHydrator();
        $this->requestBuilder = $requestBuilder ?: new RequestBuilder();
    }

    public static function create(string $endpoint, string $clientId, string $clientSecret): self
    {
        $clientConfigurator = new ClientConfigurator();
        $clientConfigurator->setEndpoint($endpoint);

        return new SyliusClient($clientConfigurator, $clientId, $clientSecret);
    }

    /**
     * Autnenticate a user with the API. This will return an access token.
     * Warning, this will remove the current access token.
     */
    public function createNewAccessToken(string $username, string $password): string
    {
        $this->getHttpClientConfigurator()->removePlugin(AuthenticationPlugin::class);
        $request = $this->requestBuilder->create('POST', '/api/oauth/v2/token', [
            'Content-type' => 'application/x-www-form-urlencoded',
        ], http_build_query([
            'client_id'=>$this->clientId,
            'client_secret'=>$this->clientSecret,
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ]));
        $response = $this->clientConfigurator->createConfiguredClient()->sendRequest($request);

        return $response->getBody()->__toString();
    }

    /**
     * The access token may have been refreshed during the requests. Use this function to
     * get back the (possibly) refreshed access token.
     */
    public function getAccessToken(): string
    {
        return $this->authenticationPlugin->getAccessToken();
    }

    /**
     * Autenticate the client with an access token. This should be the full access token object with
     * refresh token and expirery timestamps.
     *
     * ```php
     *   $accessToken = $client->createNewAccessToken('foo', 'bar');
     *   $client->authenticate($accessToken);
     *```
     */
    public function authenticate(string $accessToken): void
    {
        $this->getHttpClientConfigurator()->removePlugin(AuthenticationPlugin::class);
        $this->getHttpClientConfigurator()->appendPlugin($this->authenticationPlugin = new AuthenticationPlugin($accessToken));
    }

    public function customers(): Api\Customers
    {
        return new Api\Customers($this->getHttpClient(), $this->hydrator, $this->requestBuilder);
    }

    public function carts(): Api\Carts
    {
        return new Api\Carts($this->getHttpClient(), $this->hydrator, $this->requestBuilder);
    }

    public function products(): Api\Products
    {
        return new Api\Products($this->getHttpClient(), $this->hydrator, $this->requestBuilder);
    }

    public function checkouts(): Api\Checkouts
    {
        return new Api\Checkouts($this->getHttpClient(), $this->hydrator, $this->requestBuilder);
    }

    private function getHttpClient(): HttpClient
    {
        return $this->clientConfigurator->createConfiguredClient();
    }

    protected function getHttpClientConfigurator(): ClientConfigurator
    {
        return $this->clientConfigurator;
    }
}
