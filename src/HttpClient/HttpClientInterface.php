<?php

declare(strict_types=1);

namespace Gruzoveek\SberbankAcquiring\HttpClient;

use Gruzoveek\SberbankAcquiring\Exception\NetworkException;


interface HttpClientInterface
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    /**
     * Send an HTTP request.
     *
     * @throws NetworkException
     *
     * @return array A response
     */
    public function request(string $uri, string $method = self::METHOD_GET, array $headers = [], string $data = ''): array;
}
