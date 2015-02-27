<?php

use Behat\Behat\Context\BehatContext;
use Guzzle\Swagger\Responses\ResourceListing;
use Guzzle\Swagger\Responses\SwaggerResponse;
use Guzzle\Swagger\SwaggerClient;

require_once 'vendor/autoload.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /** @var  Array $config */
    private $config;

    /** @var  SwaggerClient $client */
    private $client;

    /** @var  Exception $exception */
    private $exception;

    /** @var  SwaggerResponse $result */
    private $result;

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
        $this->config['base_url'] = 'http://reverb.com/api';

        $is_valid = (bool) filter_var($this->config['base_url'], FILTER_VALIDATE_URL);
        PHPUnit_Framework_Assert::assertTrue($is_valid, 'The URL setup by this step is not valid');
        PHPUnit_Framework_Assert::assertArrayHasKey('base_url', $this->config, 'The step failed to set a base_url on the configuration');
    }

    /**
     * @When /^I call SwaggerClient\->Factory$/
     */
    public function iCallSwaggerClientFactory()
    {
        // Reset these, just to be safe
        $this->client = null;
        $this->exception = null;

        $config = $this->config;
        try {
            $this->client = SwaggerClient::factory($config);
        } catch (Exception $ex) {
            $this->exception = $ex;
        }
    }

    /**
     * @Then /^I should receive a SwaggerClient$/
     */
    public function iShouldReceiveASwaggerClient()
    {
        if ($this->exception)
        {
            PHPUnit_Framework_Assert::fail("An exception was thrown during factory construction:\n" . $this->exception->getMessage());
        }

        // TODO: Add message
        PHPUnit_Framework_Assert::assertInstanceOf('Guzzle\Swagger\SwaggerClient', $this->client);
    }

    /**
     * @Given /^the configuration does not have a base_url$/
     */
    public function theConfigurationDoesNotHaveABase_url()
    {
        if (!isset($this->config)){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a configuration object');
        }

        PHPUnit_Framework_Assert::assertArrayNotHasKey('base_url', $this->config, 'The configuration had a base_url upon completing this step');
    }

    /**
     * @Then /^I should receive an error$/
     */
    public function iShouldReceiveAnError()
    {
        PHPUnit_Framework_Assert::assertNotNull($this->exception, 'An exception was expected, but was not thrown');
    }

    /**
     * @Given /^the error should state that a base_url is required$/
     */
    public function theErrorShouldStateThatABase_urlIsRequired()
    {
        PHPUnit_Framework_Assert::assertStringStartsWith('Config is missing the following keys:', $this->exception->getMessage(),  'The received exception does not have the expected message');
        PHPUnit_Framework_Assert::assertTrue(strpos($this->exception->getMessage(), 'base_url') >= 0);
    }

    /**
     * @Given /^the configuration has an invalid base_url$/
     */
    public function theConfigurationHasAnInvalidBase_url()
    {
        if (!isset($this->config)){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a configuration object');
        }

        $this->config['base_url'] = 'some_invalid_url';

        $is_valid = (bool) filter_var($this->config['base_url'], FILTER_VALIDATE_URL);
        PHPUnit_Framework_Assert::assertFalse($is_valid, 'The URL setup by this step should not be valid');
        PHPUnit_Framework_Assert::assertArrayHasKey('base_url', $this->config, 'The step failed to set a base_url on the configuration');
    }

    /**
     * @Given /^a SwaggerClient$/
     */
    public function aSwaggerClient()
    {
        $this->aSwaggerClientConfiguration();
        $this->theConfigurationHasAValidBase_url();
        $this->iCallSwaggerClientFactory();
    }

    /**
     * @When /^getResourceListing is called$/
     */
    public function getResourcelistingIsCalled()
    {
        if (!isset($this->client)){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a SwaggerClient');
        }
        // Reset, just to be safe
        $this->result = null;
        $this->exception = null;

        try {
            $this->result = $this->client->getResourceListing('doc');
        } catch (Exception $ex) {
            $this->exception = $ex;
        }
    }

    /**
     * @When /^getAPIDeclaration is called$/
     */
    public function getAPIdeclarationIsCalled()
    {
        if (!isset($this->client)){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a SwaggerClient');
        }

        $this->theResourceListingHasResources();

        /** @var Resource[] $resources */
        $resources = $this->result->apis;
        foreach ($resources as $resource) {
            // Reset these, just in case
            $this->result = null;
            $this->exception = null;

            try {
                $this->result = $this->client->getAPIDeclaration($resource);
            } catch (Exception $ex) {
                $this->exception = $ex;
            }
            break; // Just do one for now
        }
    }

    /**
     * @Then /^the result is an instance of ([^"]*)$/
     */
    public function theResultShouldBeAResourceListing($class)
    {
        if (!isset($this->result)){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a SwaggerResponse');
        }

        // TODO: Add message
        PHPUnit_Framework_Assert::assertInstanceOf('Guzzle\Swagger\Responses\ResourceListing', $this->result );
    }

    /**
     * @Given /^the result (may|must) have (a|an) ([^"]*) property$/
     * @param bool $required
     * @param string $property
     */
    public function theResultHasProperty($required, $a, $property)
    {
        if (!isset($this->result) || !$this->result instanceof ResourceListing){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a ResourceListing result');
        }

        $constraint = new PHPUnit_Framework_Constraint_ClassHasProperty($property);
        PHPUnit_Framework_Assert::assertThat($this->result, $constraint, 'The ResourceListing did not have the required ' . $property . ' property.  The property cannot declared via a PHPDoc.');
        if ($required == "must")
        {
            $value = $this->result->$property;
            PHPUnit_Framework_Assert::assertNotEmpty($value, 'The ResourceListing did not a value for it\'s '. $property . ' property');
        }
    }

    /**
     * @Given /^the result's apis property must be an array of Resources$/
     */
    public function theResultHasArrayOfClass()
    {
        if (!isset($this->result) || !$this->result instanceof ResourceListing){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a ResourceListing result');
        }

        $this->theResultHasProperty(true, null, 'apis');
        $property = $this->result->apis;

        PHPUnit_Framework_Assert::isTrue(is_array($property), 'The ResourceListing apis property must be an array.');
        foreach ($property as $value) {
            // TODO: Add message
            PHPUnit_Framework_Assert::assertInstanceOf('Guzzle\Swagger\Responses\Resource', $value);
        }
    }

    /**
     * @Given /^a ResourceListing$/
     */
    public function aResourceListing()
    {
        $this->aSwaggerClient();
        $this->getResourcelistingIsCalled();
    }

    /**
     * @Given /^the ResourceListing has Resources$/
     */
    public function theResourceListingHasResources()
    {
        if (!isset($this->result) || !$this->result instanceof ResourceListing){
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without a ResourceListing result');
        }

        /** @var ResourceListing $this->result */
        if (empty($this->result->apis)) {
            PHPUnit_Framework_Assert::markTestSkipped('Cannot continue test without Resources in the ResourceListing');
        }
    }
}

class PHPUnit_Framework_Constraint_ClassHasProperty extends PHPUnit_Framework_Constraint_ClassHasAttribute
{

    /**
     * Evaluates the constraint for parameter $other. Returns TRUE if the
     * constraint is met, FALSE otherwise.
     *
     * @param mixed $other Value or object to evaluate.
     * @return bool
     */
    protected function matches($other)
    {
        $class = new ReflectionClass($other);

        $property = $this->attributeName;
        return $class->hasProperty($property);
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     * @since  Method available since Release 3.3.0
     */
    public function toString()
    {
        return sprintf(
            'has property "%s"',

            $this->attributeName
        );
    }
}
