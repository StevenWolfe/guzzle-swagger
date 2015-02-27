<?php
/**
 * Created by IntelliJ IDEA.
 * User: wolfe
 * Date: 2/27/15
 * Time: 12:49 PM
 */
namespace Guzzle\Swagger\Responses;

use Guzzle\Tests\Mock\CustomResponseModel;
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
class ResourceListing extends CustomResponseModel
{
    /**
     * @param Array $json
     */
    protected static function deserialize($instance, $json) {
        self::tryDeserializeProperty($instance, $json, 'swaggerVersion');
        self::tryDeserializeProperty($instance, $json, 'info', false, 'Guzzle\Swagger\Responses\Info');
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
        if (($temp = strlen($class) - strlen('[]')) >= 0 && strpos($class, '[]', $instance) !== FALSE) {
            if (!is_array($json[$property])) {
                throw new \Exception('Class Property is array, response is not');
            }

            $values = array();
            foreach ($json[$property] as $element) {
                $values[] = $class->deserialize($element);
            }

            $instance->$property = $values;

        } else {
            $value = new $class();
            $value->deserialize($json[$property]);
        }
    }

    public static function fromCommand(OperationCommand $command)
    {
        $instance = new self($command);

        $response = $instance->command->getResponse();
        //$result = $this->command->getResponseParser()->
        $json = $response->json();
        $instance->deserialize($instance, $json);

        return $instance;
    }
}
