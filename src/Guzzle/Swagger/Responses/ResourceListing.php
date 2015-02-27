<?php
/**
 * Created by IntelliJ IDEA.
 * User: wolfe
 * Date: 2/27/15
 * Time: 12:49 PM
 */
namespace Guzzle\Swagger\Responses;

use Guzzle\Service\Command\ResponseClassInterface;
use Guzzle\Service\Command\OperationCommand;

/**
 * Class ResourceListing
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#51-resource-listing
 *
 * @property string $swaggerVersion
 * @property Resource[] $apis
 * @property string $apiVersion
 * @property Info $info
 * @property Authorization[] $authorizations
 * @property OperationCommand $command
 */
class ResourceListing extends SwaggerResponse
{
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

        return $instance;
    }
}
