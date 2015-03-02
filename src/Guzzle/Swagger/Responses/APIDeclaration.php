<?php
/**
 * Created by IntelliJ IDEA.
 * User: wolfe
 * Date: 2/27/15
 * Time: 12:51 PM
 */
namespace Guzzle\Swagger\Responses;
use Guzzle\Service\ClientInterface;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\ServiceDescription;

/**
 * Class APIDeclaration
 * @property string swaggerVersion
 * @property string apiVersion
 * @property string basePath
 * @property string resourcePath
 * @property API[] apis
 * @property Model[] models
 * @property string[] produces
 * @property string[] consumes
 * @property Authorization[] authorizations
 *
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#52-api-declaration
 */
class APIDeclaration extends SwaggerResponse
{
    // TODO: URI, client aren't part of the swagger spec, refactor it away or add notes/docs
    public $uri, $client;
    public $swaggerVersion;
    public $apiVersion;
    public $basePath;
    public $resourcePath;
    public $apis;
    public $models;
    public $produces;
    public $consumes;
    public $authorizations;

    /**
     * @param Array $json
     */
    function deserialize($command, $instance, $json) {
        self::tryDeserializeProperty($command, $instance, $json, 'swaggerVersion', true);
        self::tryDeserializeProperty($command, $instance, $json, 'apiVersion', false);
        self::tryDeserializeProperty($command, $instance, $json, 'basePath', true);
        self::tryDeserializeProperty($command, $instance, $json, 'resourcePath', false);
        self::tryDeserializeProperty($command, $instance, $json, 'apis', true, 'Guzzle\Swagger\Responses\API[]');
        // TODO: Review if this should be Model[] or a new Models aggregate
        //self::tryDeserializeProperty($command, $instance, $json, 'models', false, 'Guzzle\Swagger\Responses\Model[]');
        // TODO: Handle produces/consumes, string[]
        //self::tryDeserializeProperty($command, $instance, $json, 'produces', false);
        //self::tryDeserializeProperty($command, $instance, $json, 'consumes', false);
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

    /**
     * @param ClientInterface $client
     * @return ServiceDescription
     */
    public function getServiceDescription(ClientInterface $client) {


        $service = new ServiceDescription(array(
            //'name' => $listing->info ? $listing->info->title : null,
            //'summary' => $listing->info ? $listing->info->description : null,
            //'apiVersion' => $listing->apiVersion,
            'baseUrl' => $client->getConfig('base_url') // TODO: Get this from the listing--or get the listing from the client
        ));
    }
}
