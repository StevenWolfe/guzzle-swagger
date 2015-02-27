Feature: Resource Listings
  In order to discover API operations
  As a Library consumer
  I want to interact with Swagger Resource Listings

  Scenario: Get Resource Listing
    Given a SwaggerClient
    When getResourceListing is called
    Then the result is an instance of ResourceListing
    And the result must have a swaggerVersion property
    And the result must have an apis property
    And the result's apis property must be an array of Resources
    # TODO: Consider checking the Resource schema here
    #And the Resources must have a path property
    And the result may have an apiVersion property
    And the result may have an info property
    And the result may have an authorizations property

  Scenario: Get Resource Operations
    Given a SwaggerClient
    And a ResourceListing
    And the ResourceListing has Resources
    When getAPIDeclaration is called
    Then the result is an instance of APIDeclaration
    And the result must have a swaggerVersion property
    And the result may have an apiVersion property
    And the result must have a basePath property
    And the result may have a resourcePath property
    And the result must have an apis property
    And the result may have a models property
    And the result may have a produces property
    And the result may have a consumes property
    And the result may have a authorizations property