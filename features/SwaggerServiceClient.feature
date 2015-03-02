Feature: Swagger Client Builder
  In order to communicate with a Swagger capable service
  As a library consumer
  I want the SwaggerClient to construct and configure a Service Client for the webservice

Scenario: Swagger Client Building
  Given a SwaggerClient
  And a ResourceListing
  And the ResourceListing has Resources
  When getServiceClient is called
  Then a SwaggerServiceClient is returned