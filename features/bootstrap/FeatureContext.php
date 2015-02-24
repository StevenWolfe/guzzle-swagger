<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Guzzle\Swagger\SwaggerClient;

require_once 'vendor/autoload.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    private $config, $client;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @Given /^a SwaggerClient configuration$/
     */
    public function aSwaggerClientConfiguration()
    {
        $this->config = array();
        PHPUnit_Framework_Assert::assertNotNull($this->config, 'Setup Failed: The config variable should not be null');
    }

    /**
     * @Given /^the configuration has a valid base_url$/
     */
    public function theConfigurationHasAValidBase_url()
    {
        if (is_null($this->config)){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a configuration object');
        }

        $this->config['base_url'] = 'http://example.org/api-docs';

        $is_valid = (bool) filter_var($this->config['base_url'], FILTER_VALIDATE_URL);
        PHPUnit_Framework_Assert::assertTrue($is_valid, 'The URL setup by this step is not valid');
        PHPUnit_Framework_Assert::assertArrayHasKey('base_url', $this->config, 'The step failed to set a base_url on the configuration');
    }

    /**
     * @When /^I call SwaggerClient\->Factory$/
     */
    public function iCallSwaggerClientFactory()
    {
        $config = $this->config;
        $this->client = SwaggerClient::factory($config);
        throw new PendingException();
    }

    /**
     * @Then /^I should receive a SwaggerClient$/
     */
    public function iShouldReceiveASwaggerClient()
    {
        throw new PendingException();
    }

    /**
     * @Given /^the configuration does not have a base_url$/
     */
    public function theConfigurationDoesNotHaveABase_url()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should receive an error$/
     */
    public function iShouldReceiveAnError()
    {
        throw new PendingException();
    }

    /**
     * @Given /^the error should state that a base_url is required$/
     */
    public function theErrorShouldStateThatABase_urlIsRequired()
    {
        throw new PendingException();
    }

    /**
     * @Given /^the configuration has an invalid base_url$/
     */
    public function theConfigurationHasAnInvalidBase_url()
    {
        throw new PendingException();
    }
}
