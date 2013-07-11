<?php

namespace Jcroll\FoursquareApiBundle\Tests\Client;

use Jcroll\FoursquareApiBundle\Client\FoursquareClient;

class FoursquareClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $clientId
     * @param $clientSecret
     *
     * @dataProvider provideConfigValues
     */
    public function testFactoryReturnsClient($clientId, $clientSecret)
    {
        $config = array(
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        );

        $client = FoursquareClient::factory($config);

        $this->assertInstanceOf('\Jcroll\FoursquareApiBundle\Client\FoursquareClient', $client);
        $this->assertEquals($config['client_id'], $client->getDefaultOption('query')['client_id']);
        $this->assertEquals($config['client_secret'], $client->getDefaultOption('query')['client_secret']);
    }

    /**
     * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
     */
    public function testFactoryReturnsExecptions()
    {
        $config = array();

        $client = FoursquareClient::factory($config);
    }

    /**
     * @param $clientId
     * @param $clientSecret
     *
     * @dataProvider provideConfigValues
     */
    public function testAddToken($clientId, $clientSecret)
    {
        $config = array(
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        );

        $token = 'secretToken';

        $client = FoursquareClient::factory($config);
        $client->addToken($token);

        $this->assertEquals($token, $client->getDefaultOption('query')['oauth_token']);
    }

    public function provideConfigValues()
    {
        return array(
            array('aClientId', 'aClientSecret')
        );
    }
}