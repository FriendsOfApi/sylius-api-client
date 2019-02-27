<?php

declare(strict_types=1);

namespace FAPI\Sylius\Http;

use FAPI\Sylius\RequestBuilder;
use Http\Client\HttpClient;

/**
 * Class that gets access tokens.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 *
 * @internal
 */
final class Authenticator
{
    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var string|null
     */
    private $accessToken;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    public function __construct(RequestBuilder $requestBuilder, HttpClient $httpClient, string $clientId, string $clientSecret)
    {
        $this->requestBuilder = $requestBuilder;
        $this->httpClient = $httpClient;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function createAccessToken(string $username, string $password): ?string
    {
        $request = $this->requestBuilder->create('POST', '/api/oauth/v2/token', [
            'Content-type' => 'application/x-www-form-urlencoded',
        ], \http_build_query([
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ]));

        $response = $this->httpClient->sendRequest($request);
        if (200 !== $response->getStatusCode()) {
            return null;
        }

        $this->accessToken = $response->getBody()->__toString();

        return $this->accessToken;
    }

    public function refreshAccessToken(string $accessToken, string $refreshToken): ?string
    {
        $request = $this->requestBuilder->create('POST', '/api/oauth/v2/token', [
            'Authorization' => \sprintf('Bearer %s', $accessToken),
            'Content-type' => 'application/x-www-form-urlencoded',
        ], \http_build_query([
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]));

        $response = $this->httpClient->sendRequest($request);
        if (200 !== $response->getStatusCode()) {
            return null;
        }

        $this->accessToken = $response->getBody()->__toString();

        return $this->accessToken;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }
}
