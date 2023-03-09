<?php

declare(strict_types=1);

namespace Gruzoveek\SberbankAcquiring\Exception;


class BadResponseException extends SberbankAcquiringException
{
    private string $response;

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(string $response): void
    {
        $this->response = $response;
    }
}
