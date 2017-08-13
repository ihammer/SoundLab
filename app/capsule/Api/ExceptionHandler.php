<?php namespace Capsule\Api;

use Exception;
use Config;
use Illuminate\Exception\Handler;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Capsule\Core\Support\Exceptions\ValidationFailureException;
use Capsule\Core\Support\Exceptions\PermissionDeniedException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionHandler extends Handler {

    protected function displayException($e)
    {
        $request = \Request::instance();
        if ($request->is('api/*')) {
            if ($e instanceof ValidationFailureException) {
                return $this->renderValidationException($e);
            }
            if ($e instanceof PermissionDeniedException) {
                return new Response(null, 401);
            }
            $error = [];
            if (Config::get('app.debug')) {
                $error['code'] = (new \ReflectionClass($e))->getShortName();
            }

            if ($detail = $e->getMessage()) {
                $error['detail'] = $detail;
            }

            // status code
            $statusCode = $e instanceof HttpException ? $e->getStatusCode() : 500;
            if (count($error)) {
                return $this->renderErrors([$error], $statusCode);
            } else {
                return new Response(null, $statusCode);
            }
        }
        return parent::displayException($e);
    }
    
    protected function renderErrors($errors, $httpCode = 500)
    {
        return new JsonResponse(['errors' => $errors], $httpCode);
    }

    protected function renderValidationException(ValidationFailureException $e)
    {
        $errors = [];
        foreach ($e->getErrors()->getMessages() as $field => $messages) {
            $errors[] = [
                'detail' => implode("\n", $messages),
                'path' => $field
            ];
        }
        return $this->renderErrors($errors, 422);
    }
}