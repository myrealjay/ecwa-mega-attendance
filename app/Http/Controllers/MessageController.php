<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomMessageRequest;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendCustomMessage(CustomMessageRequest $request)
    {
        return (new MessageService)->send($request);
    }
}
