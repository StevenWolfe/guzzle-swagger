<?php

namespace Guzzle\Swagger\Responses;

use Guzzle\Service\Command\ResponseClassInterface;

abstract class SwaggerResponse implements ResponseClassInterface
{
    protected static function tryDeserializeProperty($instance, $json, $property, $required = true, $class = null)
    {
        // TODO: Refactor and clean this up.  It's using recursion to deserialize arrays, but it made a mess
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

            // Initialize the Array
            $instance->$property = array();

            // Remove the Array syntax
            $class = substr($class, 0, -2);

            foreach ($json[$property] as $value) {
                self::tryDeserializeProperty($instance, array($property => $value), $property, $required, $class);
            }

        } else {
            if (isset($instance->$property) && is_array($instance->$property))
            {
                $value = $instance->$property;
                $value[] = $json[$property];
                $instance->$property = $value;
            } else {
                $instance->$property = $json[$property];
            }
        }

        return $instance;
    }
}
