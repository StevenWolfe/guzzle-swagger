Feature: SwaggerClient Factory
  In order to build a SwaggerClient
  As a library consumer
  I want the SwaggerClient Factory method to configure a client for me

  Scenario: Valid Configuration Provided
    Given a SwaggerClient configuration
    And the configuration has a valid base_url
    When I call SwaggerClient->Factory
    Then I should receive a SwaggerClient

  Scenario: Incomplete Configuration Provided
    Given a SwaggerClient configuration
    And the configuration does not have a base_url
    When I call SwaggerClient->Factory
    Then I should receive an error
    And the error should state that a base_url is required

  Scenario: Invalid Configuration Provided
    Given a SwaggerClient configuration
    And the configuration has an invalid base_url
    When I call SwaggerClient->Factory
    Then I should receive an error
    And the error should state that a base_url is required

