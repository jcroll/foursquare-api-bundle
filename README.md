# JcrollFoursquareApiBundle

## Why?

There is no library built to interact with the [foursquare api](https://developer.foursquare.com/) using the fantastic
[Guzzle HTTP Client library](https://github.com/guzzle/guzzle). Guzzle is awesome and supplies a lot of great things
for building web service clients.

## Installation

Add JcrollFoursquareApiBundle in your composer.json:

```js
{
    "require": {
        "jcroll/foursquare-api-bundle": "dev-master"
    }
}
```

Download bundle:

``` bash
$ php composer.phar update jcroll/foursquare-api-bundle
```

```php
Add the JcrollFoursquareApiBundle to your AppKernel.php

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

Add your application id and secret parameters:

```yaml
jcroll_foursquare_api:
    client_id:     %your_foursquare_client_id%
    client_secret: %your_foursquare_client_secret%
```

## Usage

```php
$client = $this->container->get('jcroll_foursquare_client');
$client->addToken($oauthToken); //optional for user specific requests
$command = $client->getCommand('GetVenues', $venueId);
$results = $command->execute();
```

You can find a list of the client's available commands in the bundle's
[client.json](https://github.com/jcroll/foursquare-api-bundle/blob/master/Resources/config/client.json).