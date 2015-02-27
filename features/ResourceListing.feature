Feature: Resource Listings
  In order to discover API operations
  As a Library consumer
  I want to interact with Swagger Resource Listings

  Scenario: Get Resource Listing
    Given a SwaggerClient
    When getResourceListing is called
    Then the result should be a ResourceListing
    And the result must have a swaggerVersion property
    And the result must have an apis property
    And the result's apis property must be an array of Resources
    And the result may have an apiVersion property
    And the result may have an info property
    And the result may have an authorizations property