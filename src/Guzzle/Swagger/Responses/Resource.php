<?php
/**
 * Created by IntelliJ IDEA.
 * User: wolfe
 * Date: 2/27/15
 * Time: 12:50 PM
 */
namespace Guzzle\Swagger\Responses;
use Guzzle\Service\Command\OperationCommand;

/**
 * Class Resource
 * @package MusicStoreLive\ReverbSDK\Swagger
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#512-resource-object
 * @property string $path
 * @property string $description
 */
class Resource implements ISwaggerResponse
{
    public $path;
    public $description;

    /**
     * @param $command
     * @param $instance
     * @param $json
     */
    function deserialize($command, $instance, $json)
    {
        // TODO: Implement deserialize() method.
        SwaggerResponse::tryDeserializeProperty($command, $instance, $json, 'path', true);
        SwaggerResponse::tryDeserializeProperty($command, $instance, $json, 'description', false);
    }
}
