<?php

namespace Guzzle\Swagger;

use Exception;
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

        // Prevent bad URLs
        if (array_key_exists('base_url', $config) && !filter_var($config['base_url'], FILTER_VALIDATE_URL)) {
            unset($config['base_url']);
        }

        // Merge default and provided configurations
        $config = Collection::fromConfig($config, $defaults, $required);

        // Build the client
        $client = new self($config->get('base_url'), $config);

        // Setup subscribers
        // none yet

        return $client;
    }
}
