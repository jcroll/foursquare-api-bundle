<?php

namespace Jcroll\FoursquareApiBundle\EventListener;

use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use Jcroll\FoursquareApiClient\Client\FoursquareClient;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OauthListener
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var FoursquareClient */
    private $client;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param FoursquareClient      $client
     */
    public function __construct(TokenStorageInterface $tokenStorage, FoursquareClient $client)
    {
        $this->tokenStorage = $tokenStorage;
        $this->client       = $client;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $token = $this->tokenStorage->getToken();

        if (!$token instanceof OAuthToken) {
            return;
        }

        if ('foursquare' !== $token->getResourceOwnerName()) {
            return;
        }

        $this->client->addToken($token->getAccessToken());
    }
}