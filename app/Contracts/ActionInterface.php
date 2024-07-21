<?php

namespace App\Contracts;

interface ActionInterface
{
    public function execute();

    public static function new($parameters = null);
}
