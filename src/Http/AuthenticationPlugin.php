<?php

declare(strict_types=1);

namespace FAPI\Sylius\Http;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * This will automatically refresh expired access token.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class AuthenticationPlugin implements Plugin
{
    /**
     * @var array
     */
    private $accessToken;

    /**
     * @var Authenticator
     */
    private $authenticator;

    public function __construct(Authenticator $authenticator, string $accessToken)
    {
        $this->authenticator = $authenticator;
        $this->accessToken = \json_decode($accessToken, true);
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        if (null === $this->accessToken) {
            return $next($request);
        }

        $header = \sprintf('Bearer %s', $this->accessToken['access_token'] ?? '');
        $request = $request->withHeader('Authorization', $header);

        $promise = $next($request);

        return $promise->then(function (ResponseInterface $response) use ($request, $next, $first) {
            if (401 !== $response->getStatusCode()) {
                return $response;
            }

            $accessToken = $this->authenticator->refreshAccessToken($this->accessToken['access_token'], $this->accessToken['refresh_token']);
            if (null === $accessToken) {
                return $response;
            }

            // Save new token
            $this->accessToken = \json_decode($accessToken, true);

            // Add new token to request
            $header = \sprintf('Bearer %s', $this->accessToken['access_token']);
            $request = $request->withHeader('Authorization', $header);

            // Retry
            $promise = $this->handleRequest($request, $next, $first);

            return $promise->wait();
        });

        return $response;
    }

    public function getAccessToken(): string
    {
        return \json_encode($this->accessToken);
    }
}
