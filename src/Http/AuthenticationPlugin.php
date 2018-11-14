<?php

declare(strict_types=1);

namespace FAPI\Sylius\Http;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthenticationPlugin implements Plugin
{
    /**
     * @var array
     */
    private $accessToken;


    public function __construct(string $accessToken)
    {
        $this->accessToken = json_decode($accessToken, true);
    }


    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $header = sprintf('Bearer %s', $this->accessToken['access_token']);
        $request =  $request->withHeader('Authorization', $header);

        $promise = $next($request);
        return $promise->then(function (ResponseInterface $response) use ($request, $next, $first) {
            if ($response->getStatusCode() === 401) {
                $x = 2;
                // Retry
                $promise = $this->handleRequest($request, $next, $first);

                return $promise->wait();
            }

            return $response;
        });



        return $response;
    }

    public function getAccessToken(): string
    {
        return json_encode($this->accessToken);
    }
}
