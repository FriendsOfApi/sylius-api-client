<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Api;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Custom extends HttpApi
{
    public function get(string $path, array $params = [], array $requestHeaders = [], string $class = '')
    {
        $response = parent::httpGet($path, $params, $requestHeaders);
        if (!$this->hydrator) {
            return $response;
        }

        return $this->hydrator->hydrate($response, $class);
    }

    public function post(string $path, array $params = [], array $requestHeaders = [], string $class = '')
    {
        $response = parent::httpPost($path, $params, $requestHeaders);
        if (!$this->hydrator) {
            return $response;
        }

        return $this->hydrator->hydrate($response, $class);
    }

    public function postRaw(string $path, $body, array $requestHeaders = [], string $class = '')
    {
        $response = parent::httpPostRaw($path, $body, $requestHeaders);
        if (!$this->hydrator) {
            return $response;
        }

        return $this->hydrator->hydrate($response, $class);
    }

    public function put(string $path, array $params = [], array $requestHeaders = [], string $class = '')
    {
        $response = parent::httpPut($path, $params, $requestHeaders);
        if (!$this->hydrator) {
            return $response;
        }

        return $this->hydrator->hydrate($response, $class);
    }

    public function patch(string $path, array $params = [], array $requestHeaders = [], string $class = '')
    {
        $response = parent::httpPatch($path, $params, $requestHeaders);
        if (!$this->hydrator) {
            return $response;
        }

        return $this->hydrator->hydrate($response, $class);
    }

    public function delete(string $path, array $params = [], array $requestHeaders = [], string $class = '')
    {
        $response = parent::httpDelete($path, $params, $requestHeaders);
        if (!$this->hydrator) {
            return $response;
        }

        return $this->hydrator->hydrate($response, $class);
    }
}
