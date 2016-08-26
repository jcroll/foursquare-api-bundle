# JcrollFoursquareApiBundle

[![Build Status](https://travis-ci.org/jcroll/foursquare-api-bundle.png)](https://travis-ci.org/jcroll/foursquare-api-bundle)

This bundle integrates the [JcrollFoursquareApiClient](https://github.com/jcroll/foursquare-api-client) into the Symfony
framework.

## Why?

This bundle will allow you to easily configure the [JcrollFoursquareApiClient](https://github.com/jcroll/foursquare-api-client) 
and additionally easily allow you to integrate with the [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle) 
(if you are using it) for signed requests to the foursquare api (see the 
[JcrollFoursquareApiBundleSandbox](https://github.com/jcroll/foursquare-api-bundle-sandbox) for examples).

## Installation

Add JcrollFoursquareApiBundle in your composer.json:

```js
{
    "require": {
        "jcroll/foursquare-api-bundle": "~1"
    }
}
```

Download bundle:

``` bash
$ php composer.phar update jcroll/foursquare-api-bundle
```

Add the JcrollFoursquareApiBundle to your AppKernel.php

```php
// app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Jcroll\FoursquareApiBundle\JcrollFoursquareApiBundle(),
            ...
        );
        ...
    }
```

## Basic configuration

1. If you're not using [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle) add your application id and secret 
   parameters:
    
    ```yaml
    # app/config/config.yml
    
    jcroll_foursquare_api:
        client_id:     <your_foursquare_client_id>     
        client_secret: <your_foursquare_client_secret> 
    ```
2. If you are using [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle) configure a `foursquare` resource owner
   and the client's credentials will automatically be configured (that's right you do not need to define this bundle in 
   `config.yml`).
    
    ```yaml
    # app/config/config.yml
    
    hwi_oauth:
        resource_owners:
            any_name:
                type:          foursquare
                client_id:     <your_foursquare_client_id>     # will automatically inject in the client
                client_secret: <your_foursquare_client_secret> # will automatically inject in the client
    ```
    
## Usage

```php
$client = $this->container->get('jcroll_foursquare_client');
$client->addToken($oauthToken); // optional for user specific requests
$command = $client->getCommand('venues/search', [
    'near'  => 'Chicago, IL',
    'query' => 'sushi'
]);
$results = (array) $client->execute($command); // returns an array of results
```

You can find a list of the client's available commands in the bundle's
[client.json](https://github.com/jcroll/foursquare-api-client/blob/master/src/Resources/config/client.json)
but basically they should be the same as the [api endpoints listed in the docs](https://developer.foursquare.com/docs/).

## HWIOAuthBundle Integration

If you are using [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle) this bundle will automatically look for
a `resource_owner` of type `foursquare` in that bundle's configuration and inject the `client_id` and `client_secret`
into the `jcroll_foursquare_client` service (no need to configure this bundle).

Additionally a listener will be configured and if the authenticated user possesses an oauth token belonging to foursquare
the token will be automatically injected into the `jcroll_foursquare_client` service for signed requests (no need to call
`addToken`).