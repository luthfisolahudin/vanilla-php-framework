<?php

declare(strict_types=1);

namespace Sys\Http;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
 * @see https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
 * @see https://github.com/yiisoft/http/blob/master/src/Status.php
 */
final class Status
{
    public const OK = 200;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.3.2
     */
    public const CREATED = 201;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.3.5
     */
    public const NO_CONTENT = 204;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.4.2
     */
    public const MOVED_PERMANENTLY = 301;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.4.7
     */
    public const TEMPORARY_REDIRECT = 307;

    /**
     * @see https://tools.ietf.org/html/rfc7238#section-3
     */
    public const PERMANENT_REDIRECT = 308;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.5.1
     */
    public const BAD_REQUEST = 400;

    /**
     * @see https://tools.ietf.org/html/rfc7235#section-3.1
     */
    public const UNAUTHORIZED = 401;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.5.3
     */
    public const FORBIDDEN = 403;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.5.4
     */
    public const NOT_FOUND = 404;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.5.5
     */
    public const METHOD_NOT_ALLOWED = 405;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.5.7
     */
    public const REQUEST_TIMEOUT = 408;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-6.5.8
     */
    public const CONFLICT = 409;

    /**
     * @see https://tools.ietf.org/html/rfc6585#section-4
     */
    public const TOO_MANY_REQUESTS = 429;

    /**
     * @var array list of HTTP status texts
     */
    public const TEXTS = [
        self::OK => 'OK',
        self::CREATED => 'Created',
        self::NO_CONTENT => 'No Content',
        self::MOVED_PERMANENTLY => 'Moved Permanently',
        self::TEMPORARY_REDIRECT => 'Temporary Redirect',
        self::PERMANENT_REDIRECT => 'Permanent Redirect',
        self::BAD_REQUEST => 'Bad Request',
        self::UNAUTHORIZED => 'Unauthorized',
        self::FORBIDDEN => 'Forbidden',
        self::NOT_FOUND => 'Not Found',
        self::METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::REQUEST_TIMEOUT => 'Request Time-out',
        self::CONFLICT => 'Conflict',
        self::TOO_MANY_REQUESTS => 'Too Many Requests',
    ];
}
