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
 * Class Parameter
 * @property string paramType
 * @property string name
 * @property string description
 * @property bool required
 * @property bool allowMultiple
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#524-parameter-object
 */
class Parameter extends SwaggerResponse
{
    /**
     * @param Array $json
     */
    function deserialize($command, $instance, $json) {
        self::tryDeserializeProperty($command, $instance, $json, 'paramType', true);
        self::tryDeserializeProperty($command, $instance, $json, 'name', true);
        self::tryDeserializeProperty($command, $instance, $json, 'description', false);
        self::tryDeserializeProperty($command, $instance, $json, 'required', false);
        self::tryDeserializeProperty($command, $instance, $json, 'allowMultiple', false);
    }

    public static function fromCommand(OperationCommand $command)
    {
        $instance = new self();
        $response = $command->getResponse();
        $json = $response->json();
        $instance->deserialize($command, $instance, $json);

        //TODO: Validate paramType
        /* Required.
        The type of the parameter (that is, the location of the parameter in the
        request). The value MUST be one of these values: "path", "query", "body",
        "header", "form". Note that the values MUST be lower case.
        */

        return $instance;
    }
}
