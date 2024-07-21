<?php

namespace App\Traits;

trait HasActionConstructor
{
    protected array $requestData;
    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
    }

    public static function new($data = null)
    {
        return new self($data);
    }
}
