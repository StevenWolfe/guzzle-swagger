<?php
/**
 * Created by IntelliJ IDEA.
 * User: wolfe
 * Date: 2/27/15
 * Time: 12:51 PM
 */
namespace Guzzle\Swagger\Responses;
use Guzzle\Service\Command\ResponseClassInterface;
use Guzzle\Service\Command\OperationCommand;

/**
 * Class API
 * @property string path
 * @property string description
 * @property Operation[] operations
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#522-api-object
 */
class API extends SwaggerResponse
{
    /**
     * @param Array $json
     */
    function deserialize($command, $instance, $json) {
        self::tryDeserializeProperty($command, $instance, $json, 'path', true);
        self::tryDeserializeProperty($command, $instance, $json, 'description', false);
        self::tryDeserializeProperty($command, $instance, $json, 'operations', true, 'Guzzle\Swagger\Responses\Operation[]');
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
