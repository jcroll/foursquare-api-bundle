<?php

namespace Jcroll\FoursquareApiBundle\Client;

use Guzzle\Common\Collection;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class FoursquareClient extends Client
{
    public static function factory($config = array())
    {
        $default = array('base_url' => 'https://api.foursquare.com/v2');

        $required = array(
            'client_id',
            'client_secret',
        );

        $config = Collection::fromConfig($config, $default, $required);

        $client = new self($config->get('base_url'), $config);
        $client->setDefaultOption('query',  $config);

        return $client;
    }
}