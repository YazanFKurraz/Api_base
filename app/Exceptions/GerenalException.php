<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait GerenalException
{
    public function apiException($request, $exception)
    {

        if ($this->isHttp($exception)) {
            return $this->sendResponse(false, 'Error page not found and path url', null, 404);
        }

        if ($this->isModel($exception)) {
            return $this->sendResponse(false, 'Error model not found', null, 404);
        }

        if ($this->otherError($exception)) {
            return $this->sendResponse(false, 'Exception error', null, 404);
        }
        if ($this->isQuery($exception)) {
            return $this->sendResponse(false, 'Query error please check name column', null, 404);
        }
    }

    public function isHttp($exception)
    {
        return $exception instanceof NotFoundHttpException;
    }

    public function isModel($exception)
    {
        return $exception instanceof ModelNotFoundException;
    }

    public function otherError($exception)
    {
        return $exception instanceof ErrorException;
    }

    public function isQuery($exception)
    {
        return $exception instanceof QueryException;
    }
}
