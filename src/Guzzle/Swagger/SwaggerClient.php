<?php

namespace Guzzle\Swagger;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;

class SwaggerClient extends Client
{
    public static function factory($config = array())
    {
        // Default Options
        $defaults = array();

        // Required Options
        $required = array('base_url');

        // Merge default and provided configurations
        $config = Collection::fromConfig($config, $defaults, $required);

        // Build the client
        $client = new self($config->get('base_url'), $config);

        // Setup subscribers
        // none yet

        return $client;
    }
}
