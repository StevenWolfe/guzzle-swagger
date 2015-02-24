<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
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
        throw new PendingException();
    }

    /**
     * @Given /^the configuration has a valid base_url$/
     */
    public function theConfigurationHasAValidBase_url()
    {
        throw new PendingException();
    }

    /**
     * @When /^I call SwaggerClient\->Factory$/
     */
    public function iCallSwaggerClientFactory()
    {
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
