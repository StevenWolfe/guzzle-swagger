<?php

namespace MusicStoreLive\ReverbSDK\Swagger;

/**
 * Class ResourceListing
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#51-resource-listing
 *
 * @property string $swaggerVersion
 * @property Resource[] $apis
 * @property string $apiVersion
 * @property Info $info
 * @property Authorization[] $authorizations
 */
class ResourceListing {}

/**
 * Class Resource
 * @package MusicStoreLive\ReverbSDK\Swagger
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#512-resource-object
 * @property string $path
 * @property string $description
 */
class Resource {}

/**
 * Class Info
 * @package MusicStoreLive\ReverbSDK\Swagger
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#513-info-object
 *
 * @property string $title
 * @property string $description
 * @property string $termsOfServiceUrl
 * @property string $contact
 * @property string $license
 * @property string $licenseUrl;
 */
class Info {}

// Just an associative Authorization[]
//class Authorizations{
//
//}

/**
 * Class Authorization
 * @property string type
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#515-authorization-object
 *
 */
class Authorization {}

/**
 * Class Scope
 * @property string scope
 * @property string description
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#516-scope-object
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#5211-scope-object
 *
 */
class Scope{}

/**
 * Class GrantType
 * @property Implicit implicit
 * @property AuthorizationCode authorizationCode
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#517-grant-types-object
 */
class GrantType {}

/**
 * Class Implicit
 * @property LoginEndpoint loginEndPoint
 * @property string tokenName
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#518-implicit-object
 */
class Implicit {}

/**
 * Class AuthorizationCode
 * @property TokenRequestEndpoint tokenRequestEndpoint
 * @property TokenEndpoint tokenEndpoint
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#519-authorization-code-object
 */
class AuthorizationCode {}

/**
 * Class LoginEndpoint
 * @property string url
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#5110-login-endpoint-object
 */
class LoginEndpoint {}

/**
 * Class TokenRequestEndpoint
 * @property string url
 * @property string clientIdName
 * @property string clientSecretName
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#5111-token-request-endpoint-object
 */
class TokenRequestEndpoint{}

/**
 * Class TokenEndpoint
 * @property string url
 * @property string tokenName
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#5112-token-endpoint-object
 */
class TokenEndpoint{}

/**
 * Class APIDeclaration
 * @property string swaggerVersion
 * @property string apiVersion
 * @property string basePath
 * @property string resourcePath
 * @property API[] apis
 * @property Model[] models
 * @property string[] produces
 * @property string[] consumes
 * @property Authorization[] authorizations
 *
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#52-api-declaration
 */
class APIDeclaration {}

/**
 * Class API
 * @property string path
 * @property string description
 * @property Operation[] operations
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#522-api-object
 */
class API {}

/**
 * Class Operation
 * @property string method
 * @property string summary
 * @property string notes
 * @property string nickname
 * @property Authorization[] authorizations
 * @property Parameter[] parameters
 * @property ResponseMessage[] responseMessages
 * @property string[] produces
 * @property string[] consumes
 * @property string deprecated
 *
 * @package MusicStoreLive\ReverbSDK\Swagger
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#523-operation-object
 *
 */
class Operation {}

/**
 * Class Parameter
 * @property string paramType
 * @property string name
 * @property string description
 * @property bool required
 * @property bool allowMultiple
 * @package MusicStoreLive\ReverbSDK\Swagger
 *
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#524-parameter-object
 */
class Parameter {}

/**
 * Class ResponseMessage
 * @property int code
 * @property string message
 * @property string responseModel
 * @package MusicStoreLive\ReverbSDK\Swagger
 */
class ResponseMessage {}

/**
 * Class Model
 * @property string id
 * @property string description
 * @property string[] required
 * @property Property[] properties
 * @property string[] subTypes
 * @property string discriminator
 * @package MusicStoreLive\ReverbSDK\Swagger
 * @see https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#527-model-object
 */
class Model {}

/**
 * Class Property
 * @property string description
 * @package MusicStoreLive\ReverbSDK\Swagger
 * https://github.com/swagger-api/swagger-spec/blob/master/versions/1.2.md#529-property-object
 */
class Property{}