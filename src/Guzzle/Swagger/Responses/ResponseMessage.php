<?php
/**
 * Created by IntelliJ IDEA.
 * User: wolfe
 * Date: 2/27/15
 * Time: 12:52 PM
 */
namespace Guzzle\Swagger\Responses;
use Guzzle\Service\Command\OperationCommand;

/**
 * Class ResponseMessage
 * @property int code
 * @property string message
 * @property string responseModel
 * @package MusicStoreLive\ReverbSDK\Swagger
 */
class ResponseMessage extends SwaggerResponse
{
    /**
     * @param Array $json
     */
    function deserialize($command, $instance, $json) {
        self::tryDeserializeProperty($command, $instance, $json, 'code', true);
        self::tryDeserializeProperty($command, $instance, $json, 'message', true);
        self::tryDeserializeProperty($command, $instance, $json, 'responseModel', false);
    }

    public static function fromCommand(OperationCommand $command)
    {
        $instance = new self();
        $response = $command->getResponse();
        $json = $response->json();
        $instance->deserialize($command, $instance, $json);

        // TODO: Validate code and message
        /*
        code - Required.
        The HTTP status code returned. The value SHOULD be one of the status
        codes as described in RFC 2616 - Section 10.

        message - Required.
        The explanation for the status code. It SHOULD be the reason an error
        is received if an error status code is used.
        */

        return $instance;
    }
}
