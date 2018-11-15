# Sylius API client

[![Latest Version](https://img.shields.io/github/release/FriendsOfApi/boilerplate.svg?style=flat-square)](https://github.com/FriendsOfApi/boilerplate/releases)
[![Build Status](https://img.shields.io/travis/FriendsOfApi/boilerplate.svg?style=flat-square)](https://travis-ci.org/FriendsOfApi/boilerplate)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/FriendsOfApi/boilerplate.svg?style=flat-square)](https://scrutinizer-ci.com/g/FriendsOfApi/boilerplate)
[![Quality Score](https://img.shields.io/scrutinizer/g/FriendsOfApi/boilerplate.svg?style=flat-square)](https://scrutinizer-ci.com/g/FriendsOfApi/boilerplate)
[![Total Downloads](https://img.shields.io/packagist/dt/friendsofapi/boilerplate.svg?style=flat-square)](https://packagist.org/packages/friendsofapi/boilerplate)

## Install

Via Composer

``` bash
$ composer require friendsofapi/sylius-api-client
```

## Usage

``` php
$apiClient = SyliusClient::create($endpoint, $clientId, $clientSecret);
$accessToken = $apiClient->createNewAccessToken($username, $password);
$apiClient->authenticate($accessToken);
$allProducts = $apiClient->product()->getAll()
```

## Develop

APIs are usually split into categories, called **Resources**.
In your implementation you should also reflect these categories, for example by having their own classes in `Api/`.
Let's take a look at `Api/Stats` in our case. The response of any call should be an object in `Model/Stats/X`,
like `Model/Stats/Total`.


### Hydrator

The end user chooses which hydrator to use. The default one should return domain objects.


### Request builder

The request builder creates a PSR-7 request with a multipart stream when necessary
If the API does not require multipart streams you should remove the `RequestBuilder`
and replace it with a `RequestFactory`.



## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
