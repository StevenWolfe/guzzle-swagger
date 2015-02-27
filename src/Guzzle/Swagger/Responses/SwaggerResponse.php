<?php

namespace Guzzle\Swagger\Responses;

use Guzzle\Service\Command\ResponseClassInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

interface ISwaggerResponse
{
    /**
     * @param $command
     * @param $instance
     * @param $json
     * @return void
     */
    function deserialize($command, $instance, $json);
}

abstract class SwaggerResponse implements ResponseClassInterface, ISwaggerResponse
{

    public static function tryDeserializeProperty($command, $instance, $json, $property, $required = true, $class = null)
    {
        // TODO: Refactor and clean this up.  It's using recursion to deserialize arrays, but it made a mess.
        // Consider making most classes implement as IDeserializable interface, leaving the Response interface for the
        // root entity
        if (!array_key_exists($property, $json))
        {
            if ($required) {
                throw new \Exception('Class Property not found on response');
            }
            return $instance;
        }

        // Treat as a string if no class is specified
        if (!isset($class)){
            $instance->$property = $json[$property];
            return $instance;
        }

        // Check if class is an array
        if (($temp = strlen($class) - strlen('[]')) >= 0 && strpos($class, '[]', $temp) !== FALSE) {
            if (!is_array($json[$property])) {
                throw new \Exception('Class Property is array, response is not');
            }

            // Initialize the Array
            $instance->$property = array();

            // Remove the Array syntax
            $class = substr($class, 0, -2);

            foreach ($json[$property] as $value) {
                self::tryDeserializeProperty($command, $instance, array($property => $value), $property, $required, $class);
            }

        } else {
            if (isset($instance->$property) && is_array($instance->$property))
            {
                if (class_implements($class, 'ISwaggerResponse')) {
                    /** @var ISwaggerResponse  $value */
                    $value = new $class();
                    $value->deserialize($command, $value, $json[$property]);
                } else {
                    throw new Exception("Figure this out");
                }
                $values = $instance->$property;
                // TODO: Consider adding these with a key, configured by the value's class (e.g. 'path' for Resource)
                $values[] = $value;
                $instance->$property = $values;
            } else {
                $instance->$property = $json[$property];
            }
        }

        return $instance;
    }
}
