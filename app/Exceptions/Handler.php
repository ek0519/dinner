<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|\Illuminate\Http\Response|Response|void
     */
    public function render($request, Throwable $e)
    {
        return $this->handleException($request, $e);
    }

    public function handleException(Request $request, Throwable $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(405, 'The specified method for the request is invalid');
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse(404, 'The specified URL cannot be found', );
        }

        if ($e instanceof HttpException) {
            return $this->errorResponse($e->getStatusCode(), $e->getMessage());
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return $this->errorResponse(500, 'Unexpected Exception. Try later');
    }
}
