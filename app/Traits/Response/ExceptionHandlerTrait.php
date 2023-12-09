<?php

namespace App\Traits\Response;

use Exception;
use Illuminate\Support\Facades\Log;

trait ExceptionHandlerTrait
{
    /**
     * Log and throw an exception
     *
     * @param string $message
     * @return mixed
     * @throws Exception
     */
    public function logAndThrow(string $message): mixed
    {
        Log::error($message);
        throw new Exception($message);
    }

    /**
     * Log an exception
     *
     * @param string $message
     * @return void
     */
    public function log(string $message): void
    {
        Log::error($message);
    }
}