<?php
/**
 * Created by IntelliJ IDEA.
 * User: wolfe
 * Date: 2/27/15
 * Time: 12:51 PM
 */
namespace Guzzle\Swagger\Responses;
use Guzzle\Service\Command\OperationCommand;

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

        return $instance;
    }
}
