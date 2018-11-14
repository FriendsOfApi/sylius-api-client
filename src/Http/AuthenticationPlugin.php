<?php

declare(strict_types=1);

namespace FAPI\Sylius\Http;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

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
        if ($this->accessToken['expires'] < time()) {
            // TODO refresh token.
        }

        $header = sprintf('Bearer %s', $this->accessToken['access_token']);
        $request =  $request->withHeader('Authorization', $header);

        $response = $next($request);

        return $response;
    }

    public function getAccessToken(): string
    {
        return json_encode($this->accessToken);
    }
}
