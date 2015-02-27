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
    protected static function deserialize($instance, $json) {
        self::tryDeserializeProperty($instance, $json, 'swaggerVersion', true);
        self::tryDeserializeProperty($instance, $json, 'apis', true, 'Guzzle\Swagger\Responses\Resource[]');
        self::tryDeserializeProperty($instance, $json, 'apiVersion', false);
        self::tryDeserializeProperty($instance, $json, 'info', false, 'Guzzle\Swagger\Responses\Info');
        // TODO: Throw exception if Authorizations encountered, it's not yet supported
        //self::tryDeserializeProperty($instance, $json, 'authorizations', false, 'Guzzle\Swagger\Responses\Authorizations');
    }

    protected static function tryDeserializeProperty($instance, $json, $property, $required = true, $class = null)
    {
        if (!array_key_exists($property, $json))
        {
            if ($required) {
                throw new \Exception('Class Property not found on response');
            }
            return $instance;
        }

        if (!isset($class)){
            $instance->$property = $json[$property];
            return $instance;
        }

        // Check if class is an array
        if (($temp = strlen($class) - strlen('[]')) >= 0 && strpos($class, '[]', $temp) !== FALSE) {
            if (!is_array($json[$property])) {
                throw new \Exception('Class Property is array, response is not');
            }

            $values = array();
            foreach ($json[$property] as $element) {
                $values[] = $json[$property];
            }

            $instance->$property = $values;

        } else {
            $instance->$property = $json[$property];
        }
    }

    public static function fromCommand(OperationCommand $command)
    {
        $instance = new self();
        $response = $command->getResponse();
        //$result = $this->command->getResponseParser()->
        $json = $response->json();
        $instance->deserialize($instance, $json);

        return $instance;
    }
}
