<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exceptions\EntityValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $httpCode = 500;
        $response = new \stdClass();
        $response->message = "Service is unavailable.";
        if (env("APP_ENV") != "production") {
            $response->exception = new \stdClass();
            $response->exception->class = get_class($e);
            $response->exception->file  = $e->getFile();
            $response->exception->line  = $e->getLine();
            $response->exception->message = $e->getMessage();
        }

        switch ($e) {
            case $e instanceof ModelNotFoundException:
                $httpCode = 404;
                $response->message = "Resource not found.";
                break;

            case $e instanceof QueryException:
                if (strpos($e->getMessage(), "Duplicate entry") !== false) {
                    $httpCode = 409;
                    $response->message = "Resource already exists.";
                }
                break;

            case $e instanceof EntityValidationException:
                $httpCode = 422;
                $response->message = "Validation failed.";
                $response->errors  = [];
                foreach ($e->getValidationErrors() as $errorMessage) {
                    $errorObject = new \stdClass();
                    $errorObject->message = $errorMessage;
                    $response->errors[]   = $errorObject;
                }
                break;
        }

        return response()->json($response, $httpCode);
    }
}