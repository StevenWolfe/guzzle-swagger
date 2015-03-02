<?php

namespace Guzzle\Swagger;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Swagger\Plugin\PathEncodingPlugin;
use Guzzle\Swagger\Responses\APIDeclaration;
use Guzzle\Swagger\Responses\Resource;
use Guzzle\Swagger\Responses\ResourceListing;
use Guzzle\Swagger\Responses\SwaggerResponse;

/**
 * Class SwaggerClient
 * @package Guzzle\Swagger
 */
class SwaggerClient extends Client
{
    public static function factory($config = array())
    {
        // Default Options
        $defaults = array();

        // Required Options
        $required = array('base_url');

        // Prevent bad URLs
        if (array_key_exists('base_url', $config) && !filter_var($config['base_url'], FILTER_VALIDATE_URL)) {
            unset($config['base_url']);
        }

        // Merge default and provided configurations
        $config = Collection::fromConfig($config, $defaults, $required);

        // Build the client
        $client = new self($config->get('base_url'), $config);

        // Load Guzzle Service Descriptions
        $service = ServiceDescription::factory(__DIR__ . '/swaggerclient.json');
        $client->setDescription($service);

        // Setup subscribers
        $encodingPlugin = new PathEncodingPlugin();
        $client->addSubscriber($encodingPlugin);


        return $client;
    }

    /**
     * @param string $path
     * @return ResourceListing
     */
    public function getResourceListing($path = '/api-docs')
    {
        $args = array('path' => $path);

        $command = $this->getCommand('getResourceListing', $args);
        /** @var ResourceListing $result */
        $result = $command->execute();
        return $result;
    }

    /**
     * @param Resource $resource
     * @return APIDeclaration
     */
    public function getAPIDeclaration(Resource $resource) {
        $command = $this->getAPIDeclarationCommand($resource);
        return $command->execute();
    }

    /**
     * @param $resource
     * @return \Guzzle\Service\Command\CommandInterface|null
     */
    private function getAPIDeclarationCommand($resource)
    {
        $args = array('path' => $resource->path);
        $command = $this->getCommand('getAPIDeclaration', $args);
        return $command;
    }
}
