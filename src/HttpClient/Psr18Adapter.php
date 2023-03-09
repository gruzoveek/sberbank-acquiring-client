<?php

declare(strict_types=1);

namespace Gruzoveek\SberbankAcquiring\HttpClient;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;


class Psr18Adapter implements HttpClientInterface
{
    public function __construct(private ClientInterface $client, private RequestFactoryInterface $requestFactory, private StreamFactoryInterface $streamFactory) {}

    public function request(string $uri, string $method = HttpClientInterface::METHOD_GET, array $headers = [], string $data = ''): array
    {
        switch ($method) {
            case HttpClientInterface::METHOD_GET:
                $request = $this->requestFactory->createRequest('GET', $uri . '?' . $data);
                break;
            case HttpClientInterface::METHOD_POST:
                $request = $this->requestFactory->createRequest('POST', $uri);

                $body = $this->streamFactory->createStream($data);

                $request = $request->withBody($body);
                break;
            default:
                throw new \InvalidArgumentException(
                    sprintf(
                        'Invalid HTTP method "%s". Use "%s" or "%s".',
                        $method,
                        HttpClientInterface::METHOD_GET,
                        HttpClientInterface::METHOD_POST
                    )
                );
                break;
        }

        foreach ($headers as $key => $value) {
            $request = $request->withHeader($key, $value);
        }

        $response = $this->client->sendRequest($request);

        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();

        return [$statusCode, $body];
    }
}
