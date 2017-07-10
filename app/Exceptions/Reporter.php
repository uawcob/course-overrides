<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Reporter
{
    public static function wants(Exception $exception) : bool
    {
        if (app()->environment() === 'testing') {
            return false;
        }

        $ignored = [
            AuthenticationException::class,
            NotFoundHttpException::class,
        ];

        foreach ($ignored as $ignore) {
            if ($exception instanceof $ignore) {
                return false;
            }
        }

        return true;
    }
}
