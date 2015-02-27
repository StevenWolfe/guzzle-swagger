Feature: Resource Listings
  In order to discover API operations
  As a Library consumer
  I want to interact with Swagger Resource Listings

  Scenario: Get Resource Listing
    Given a SwaggerClient
    When getResourceListing is called
    Then a ResourceListing should be returned