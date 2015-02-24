# guzzle-swagger
> A Guzzle Plugin for communicating with Swagger enabled Services

## Scope
The initial version will intend to be compatible with the informal Swagger 1.1 spec and PHP 5.3.  Future versions may add support for Swagger 1.2 and 2.0, as well as PHP 5.4 and above (in turn allowing the use of Guzzle >= 4.0)

## Development
This library intends to follow a general BDD approach to development.  Behat is used to develop Acceptance Tests from a library-consumer perspective, PHPUnit is used to verify implementation details.  Pulls should not

### Setup

  1. Clone this repository
  2. `npm install`
  3. `php composer.phar update`

### Process

 * Add list of howto's (grunt, behat, phpunit, etc)

## Versions

### 0.0.1
 - PHP Project established
 - Hello World stories and tests work

## TODOs
 - @wip feature filtering (don't run them as part of the full suite)
 - grunt-watch features
 - Offline tests
 - Grunt watch -- unit and features
 - Travis Build (?)
 - Research PSR-4 compliance
