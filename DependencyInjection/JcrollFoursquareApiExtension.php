<?php

namespace Jcroll\FoursquareApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JcrollFoursquareApiExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = $this->getLoader($container);
        $loader->load('services.xml');

        $container
            ->getDefinition('jcroll_foursquare_api.foursquare_client')
            ->addArgument($config)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['HWIOAuthBundle'])) {
            return;
        }

        $config = $this->getExtensionConfig('jcroll_foursquare_api', $container, array('client_id', 'client_secret'));

        if (null === $config) {
            $this->prependCredentials($container);
        }

        $loader = $this->getLoader($container);
        $loader->load('oauth.xml');
    }

    /**
     * @param ContainerBuilder $container
     */
    private function prependCredentials(ContainerBuilder $container)
    {
        if (!$config = $this->getExtensionConfig('hwi_oauth', $container, array('resource_owners'))) {
            return;
        }

        $required = array('type', 'client_id', 'client_secret');

        foreach ($config['resource_owners'] as $resourceOwner) {
            // If not all required config keys are present
            if (count(array_intersect_key($resourceOwner, array_flip($required))) !== 3) {
                continue;
            }

            if ($resourceOwner['type'] !== 'foursquare') {
                continue;
            }

            $container->prependExtensionConfig($this->getAlias(), array(
                'client_id'     => $resourceOwner['client_id'],
                'client_secret' => $resourceOwner['client_secret'],
            ));
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return Loader\XmlFileLoader
     */
    private function getLoader(ContainerBuilder $container)
    {
        return new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    }

    /**
     * @param string           $extension
     * @param ContainerBuilder $container
     * @param array            $required
     *
     * @return array|null
     */
    private function getExtensionConfig($extension, ContainerBuilder $container, array $required)
    {
        $configs       = $container->getExtensionConfig($extension);
        $configuration = $container->getExtension($extension)->getConfiguration($configs, $container);
        $config        = $this->normalizeConfiguration($configuration, $configs);

        if (count(array_intersect_key($config, array_flip($required))) !== count($required)) {
            return null;
        }

        return $config;
    }

    /**
     * @param ConfigurationInterface $configuration
     * @param array                  $configs
     *
     * @return array
     */
    private function normalizeConfiguration(ConfigurationInterface $configuration, array $configs)
    {
        $configTree    = $configuration->getConfigTreeBuilder()->buildTree();
        $currentConfig = array();

        foreach ($configs as $config) {
            $config = $configTree->normalize($config);
            $currentConfig = $configTree->merge($currentConfig, $config);
        }

        return $currentConfig;
    }
}
