<?php

declare(strict_types=1);

namespace Sys\Http\Request;

/**
 * @see https://developer.mozilla.org/docs/Web/HTTP/Methods
 * @see https://github.com/yiisoft/http/blob/master/src/Method.php
 */
final class Method
{
    /**
     * @see https://tools.ietf.org/html/rfc7231#section-4.3.1
     */
    public const GET = 'GET';

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-4.3.3
     */
    public const POST = 'POST';

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-4.3.4
     */
    public const PUT = 'PUT';

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-4.3.5
     */
    public const DELETE = 'DELETE';

    /**
     * @see https://tools.ietf.org/html/rfc5789#section-2
     */
    public const PATCH = 'PATCH';
}
