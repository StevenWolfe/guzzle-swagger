<?php
/**
 * Created by IntelliJ IDEA.
 * User: wolfe
 * Date: 2/27/15
 * Time: 12:49 PM
 */
namespace Guzzle\Swagger\Responses;

use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Swagger\SwaggerClient;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ResourceListing
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#51-resource-listing
 *
 * @property SwaggerClient $client
 * @property string $swaggerVersion
 * @property Resource[] $apis
 * @property string $apiVersion
 * @property Info $info
 * @property Authorization[] $authorizations
 * @property OperationCommand $command
 */
class ResourceListing extends SwaggerResponse
{
    // TODO: URI, client aren't part of the swagger spec, refactor it away or add notes/docs
    public $uri, $client;

    public $swaggerVersion;

    public $apis;

    public $apiVersion;

    public $info;

    public $authorizations;

    /**
     * @param Array $json
     */
    function deserialize($command, $instance, $json) {
        self::tryDeserializeProperty($command, $instance, $json, 'swaggerVersion', true);
        self::tryDeserializeProperty($command, $instance, $json, 'apis', true, 'Guzzle\Swagger\Responses\Resource[]');
        self::tryDeserializeProperty($command, $instance, $json, 'apiVersion', false);
        self::tryDeserializeProperty($command, $instance, $json, 'info', false, 'Guzzle\Swagger\Responses\Info');
        // TODO: Throw exception if Authorizations encountered, it's not yet supported
        //self::tryDeserializeProperty($instance, $json, 'authorizations', false, 'Guzzle\Swagger\Responses\Authorizations');
    }

    public static function fromCommand(OperationCommand $command)
    {
        $instance = new self();
        $response = $command->getResponse();
        $json = $response->json();
        $instance->deserialize($command, $instance, $json);
        $instance->client = $command->getClient();
        $instance->uri = $command->getRequest()->getUrl(true);

        return $instance;
    }

    public function getAPIDeclaration()
    {
        $commands = array();
        foreach ($this->apis as $resource) {
            $commands[$resource->path] = $this->client->getCommand(
                'getAPIDeclaration',
                array('path' => $resource->path)
            );
        }

        $this->client->execute($commands);

        $services = array();
        foreach ($commands as $resourcePath => $command) {
            /** @var Resource $resource */
            $resource = null;
            foreach($this->apis as $api) {
                // TODO: Remove this foreach, it's an ugly way of finding the Resource via its path
                if ($api->path == $resourcePath){
                    $resource = $api;
                    break;
                }
            }
            /** @var CommandInterface $command */
            /** @var APIDeclaration $apiDeclaration */
            $apiDeclaration = $command->getResult();


            $service = array_key_exists($apiDeclaration->basePath, $services)
                ? $services[$apiDeclaration->basePath]
                : array(
                    'name' => $this->info ? $this->info->title : null,
                    'apiVersion' => $this->apiVersion,
                    'baseUrl' => $apiDeclaration->basePath,
                    '_description' => $resource->description
                );

            // Build Operations
            foreach ($apiDeclaration->apis as $api) {
                foreach ($api->operations as $operation) {
                    // TODO: Error if the nickname/operation already exists
                    /** @var Operation $operation */
                    $service['operations'][$operation->nickname] = array(
                        $api->path => array(
                            //'extends',
                            'httpMethod' => $operation->httpMethod | 'GET', // TODO: Make GET a configurable default
                            'uri' => $api->path,
                            'summary' => $operation->summary,
                            //'class',
                            //'responseClass',
                            'responseNotes' => $operation->notes,
                            //'responseType',
                            //'deprecated',
                            //'errorResponses => array()
                            //'data',
                            'parameters' => array(),
                            //'additionalParameters'

                            //'additionalParameters'
                        )
                    );

                    foreach ($operation->parameters as $parameter) {
                        // TODO: Refactor out the location->paramType mapping
                        $locations = array(
                            'path' => 'uri',
                            'query' => 'query',
                            'body' => 'body',
                            'header' => 'header',
                            'form' => 'json' // TODO: Review this, not sure if it's right
                        );

                        $service['operations'][$operation->nickname]['parameters'][$parameter->name] = array(
                            'name' => $parameter->name,
                            //'type'
                            //'instanceOf'
                            'required' => $parameter->required,
                            //'default'
                            //'static'
                            'description' => $parameter->description,
                            'location' => $locations[$parameter->paramType],
                            'sentAs' => $parameter->name, // This might be redundant
                            //'filters'
                        );
                    }
                }
            }

            // Build Models -- if feasible

            $services[$service['baseUrl']] = $service;
        }

        if (count($services) <> 1) {
            // TODO: Determine how to use multiple services
            throw new Exception('Generating Service Descriptions for multiple services is not yet implemented');
        }

        $services = array_values($services);
        $service = new ServiceDescription($services[0]);
        return $service;
    }
}
