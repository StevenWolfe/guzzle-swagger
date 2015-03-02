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
 * Class Operation
 * @property string method
 * @property string summary
 * @property string notes
 * @property string nickname
 * @property Authorization[] authorizations
 * @property Parameter[] parameters
 * @property ResponseMessage[] responseMessages
 * @property string[] produces
 * @property string[] consumes
 * @property string deprecated
 *
 * @package MusicStoreLive\ReverbSDK\Swagger
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#523-operation-object
 *
 */
class Operation extends SwaggerResponse
{
    public $method;
    public $summary;
    public $notes;
    public $nickname;
    public $authorizations;
    public $parameters;
    public $responseMessages;
    public $produces;
    public $consumes;
    public $deprecated;

    /**
     * @param Array $json
     */
    function deserialize($command, $instance, $json) {
        // TODO: Research why 1.1 is using "httpMethod" -- whether it's part of 1.1 or a bug in the swagger-gen
        self::tryDeserializeProperty($command, $instance, $json, 'httpMethod', true);
        self::tryDeserializeProperty($command, $instance, $json, 'summary', false);
        self::tryDeserializeProperty($command, $instance, $json, 'notes', false);
        self::tryDeserializeProperty($command, $instance, $json, 'nickname', true);
        // TODO: Throw exception if Authorizations encountered, it's not yet supported
        //self::tryDeserializeProperty($instance, $json, 'authorizations', false, 'Guzzle\Swagger\Responses\Authorizations');
        self::tryDeserializeProperty($command, $instance, $json, 'parameters', true, 'Guzzle\Swagger\Responses\Parameter[]');
        self::tryDeserializeProperty($command, $instance, $json, 'responseMessages', false, 'Guzzle\Swagger\Responses\ResponseMessage[]');
        // TODO: Handle produces/consumes, string[]
        //self::tryDeserializeProperty($command, $instance, $json, 'produces', false);
        //self::tryDeserializeProperty($command, $instance, $json, 'consumes', false);
        self::tryDeserializeProperty($command, $instance, $json, 'deprecated', false);
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
