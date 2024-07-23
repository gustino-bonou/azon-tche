<?php

namespace App\Exceptions;

use Error;
use Throwable;
use BadMethodCallException;
use Illuminate\Http\Response;
use UnexpectedValueException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\ErrorHandler\Error\ClassNotFoundError;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        $controller = new Controller();


        Log::error('Exception intercepted: ' . get_class($exception) . ' - ' . $exception->getMessage());

        $response = match (true) {
            $exception instanceof NotFoundHttpException => $controller->error("Ressource non trouvée", Response::HTTP_NOT_FOUND),
            $exception instanceof BadMethodCallException => $controller->error("Appel à une méthode non définie" . $exception->getMessage(), Response::HTTP_BAD_REQUEST),
            $exception instanceof QueryException => $controller->error("Erreur de requête" . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR),
            $exception instanceof UnexpectedValueException => $controller->error("Valeur non espérée" . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR),
            $exception instanceof RouteNotFoundException => $controller->error("Route non trouvée", Response::HTTP_NOT_FOUND),
            $exception instanceof BindingResolutionException => $controller->error("Erreur de résolution de route", Response::HTTP_INTERNAL_SERVER_ERROR),
            $exception instanceof ModelNotFoundException => $controller->error("Ressource inexistante", Response::HTTP_NOT_FOUND),
            $exception instanceof Error => $controller->error("Erreur de syntaxe" . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR),
            $exception instanceof ValidationException => ApiResponse::errorResponse($exception->validator->errors(), 422),
            $exception instanceof AuthorizationException => $controller->error("Action non autorisée", Response::HTTP_UNAUTHORIZED),
            $exception instanceof AuthenticationException => $controller->error("Veuillez vous connecter", Response::HTTP_UNAUTHORIZED),
            $exception instanceof MethodNotAllowedHttpException => $controller->error("Méthode non autorisée", Response::HTTP_METHOD_NOT_ALLOWED),
            $exception instanceof UnauthorizedException => $controller->error("Action non autorisée", Response::HTTP_UNAUTHORIZED),
            $exception instanceof TokenMismatchException => redirect()->back()->withInput()->withErrors(['message' => 'Votre session a expiré. Veuillez réessayer.']),
            $exception instanceof TransportException => redirect()->back()->withInput()->withErrors(['message' => 'Connexion internet non stable']),
            $exception instanceof \Illuminate\Http\Client\ConnectionException => $controller->error("Connexion internet non stable", 500),
            $exception instanceof \Illuminate\Http\Client\RequestException => $controller->error("Erreur de connexion au serveur", 500),
            $exception instanceof ClassNotFoundError => $controller->error("Classe non trouvée", 500),
            default => parent::render($request, $exception),
        };

        return $response;
    }
}
