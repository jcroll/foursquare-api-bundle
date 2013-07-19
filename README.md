# JcrollFoursquareApiBundle

[![Build Status](https://travis-ci.org/jcroll/foursquare-api-bundle.png)](https://travis-ci.org/jcroll/foursquare-api-bundle)

This bundle integrates the [JcrollFoursquareApiClient](https://github.com/jcroll/foursquare-api-client) into the Symfony2
framework.

## Why?

There is no library built to interact with the [foursquare api](https://developer.foursquare.com/) using the fantastic
[Guzzle HTTP Client library](https://github.com/guzzle/guzzle). Guzzle is awesome and supplies a lot of great things
for building web service clients.

## Installation

Add JcrollFoursquareApiBundle in your composer.json:

```js
{
    "require": {
        "jcroll/foursquare-api-bundle": "1.0.*"
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

Add your application id and secret parameters:

```yaml
# app/config/config.yml

jcroll_foursquare_api:
    client_id:     <your_foursquare_client_id>
    client_secret: <your_foursquare_client_secret>
```

## Usage

```php
$client = $this->container->get('jcroll_foursquare_client');
$client->addToken($oauthToken); // optional for user specific requests
$command = $client->getCommand('venues/search', array(
    'near' => 'Chicago, IL',
    'query' => 'sushi'
));
$results = $command->execute();
```

You can find a list of the client's available commands in the bundle's
[client.json](https://github.com/jcroll/foursquare-api-client/blob/master/lib/Jcroll/FoursquareApiClient/Resources/config/client.json)
but basically they should be the same as the [api endpoints listed in the docs](https://developer.foursquare.com/docs/).

## Oauth2 Integration

Authorization for user specific requests at foursquare via the Oauth 2 protocol is beyond the scope of this bundle.
Here are two libraries you might use to do that:

* [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle)
* [FOSOAuthServerBundle](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle)

After you receive your access token you can then pass it into the client as shown above.

## TODO

I haven't gotten around to adding all the endpoints yet so if you don't see the one you are looking for it's as easy as
forking the [JcrollFoursquareApiClient](https://github.com/jcroll/foursquare-api-client) and just adding your endpoint
following the schema in [client.json](https://github.com/jcroll/foursquare-api-client/blob/master/lib/Jcroll/FoursquareApiClient/Resources/config/client.json).
Then please just submit a pr and I'll be happy to include your endpoint otherwise I will work on adding them all in my
free time.
