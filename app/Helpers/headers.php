<?php

function customGetallheaders()
{
    $headers = getallheaders();
    $requestHeaders = request()->header();
    foreach ($requestHeaders as $key => $value) {
        if (count($value) > 0) {
            $headers[$key] = $value[0];
        }
    }

    return $headers;
}
