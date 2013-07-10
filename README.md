# JcrollFoursquareApiBundle

## About

The JcrollFoursquareApiBundle provides a client to interact with the [foursquare api](https://developer.foursquare.com/).
The bundle is currently focused on integrating with "userless" resources so in other words resources that do not
require an oauth token.

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
$command = $client->getCommand('GetVenues', $venueId);
$results = $command->execute();
```

You can find a list of the client's available commands in the bundle's
[client.json](https://github.com/jcroll/foursquare-api-bundle/blob/master/Resources/config/client.json).