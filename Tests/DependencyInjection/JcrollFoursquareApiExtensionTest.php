<?php

namespace Jcroll\FoursquareApiBundle\Tests\DependencyInjection;

use Jcroll\FoursquareApiBundle\DependencyInjection\JcrollFoursquareApiExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class JcrollFoursquareApiExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadEmptyConfiguration()
    {
        $config = array(
            'client_id'     => '',
            'client_secret' => ''
        );

        $this->createCompiledContainerForConfig($config);
    }

    public function testLoadConfiguration()
    {
        $config = array(
            'client_id'     => 'aClientId',
            'client_secret' => 'aClientSecret'
        );

        $container = $this->createCompiledContainerForConfig($config);

        $this->assertInstanceOf(
            '\Jcroll\FoursquareApiClient\Client\FoursquareClient',
            $container->get('jcroll_foursquare_client')
        );
    }


    private function createCompiledContainerForConfig($config, $debug = false)
    {
        $container = $this->createContainer($debug);
        $container->registerExtension(new JcrollFoursquareApiExtension());
        $container->loadFromExtension('jcroll_foursquare_api', $config);
        $this->compileContainer($container);

        return $container;
    }

    private function createContainer($debug = false)
    {
        $container = new ContainerBuilder(new ParameterBag(array(
            'kernel.cache_dir' => __DIR__,
            'kernel.charset'   => 'UTF-8',
            'kernel.debug'     => $debug,
            'kernel.bundles'   => array('JcrollFoursquareApiBundle')
        )));

        return $container;
    }

    private function compileContainer(ContainerBuilder $container)
    {
        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();
    }
}