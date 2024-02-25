<?php

namespace App\Http\Middleware;

use App\Enums\AuthStrEnum;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckTokenMiddleware
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.env') === 'local') {
            return $next($request);
        }

        $token = Cookie::get(
            config('app.env')
            . '_'
            . AuthStrEnum::JWT_NAME->value,
        );

        if (!$token) {
            return redirect()->route('app.auth');
        }

        $userAuth = $this->checkUserAuth($token);

        return $userAuth instanceof JsonResponse || $userAuth instanceof RedirectResponse
            ? $userAuth
            : $next($request);
    }

    /**
     * Check user authentication
     *
     * @param string $token
     * @return JsonResponse|RedirectResponse|JWTSubject|null
     */
    private function checkUserAuth(string $token): JWTSubject|JsonResponse|RedirectResponse|null
    {
        $authSubject = null;

        try {
            $authSubject = $this->authenticateUser($token);
            $redirected = $this->checkAccess($authSubject);

            if (!is_bool($redirected)) {
                return $redirected;
            }

        } catch (TokenExpiredException $e) {
            Log::error($e->getMessage());
            try {
                $this->handleTokenExpired();
            } catch (JWTException $e) {
                return $this->handleJwtError(
                    $e->getMessage(),
                    $e->getTraceAsString(),
                );
            }
        } catch (JWTException $e) {
            return $this->handleJWTException(
                $e,
                'Something wrong with the token',
            );
        }

        return $authSubject;
    }

    /**
     * Handle JWTException
     *
     * @param string $message
     * @param string $link
     * @return JsonResponse
     */
    protected function handleUnauthorized(string $message, string $link): JsonResponse
    {
        return self::sendSuccess(
            'Unauthorized. ' . $message,
            [
                'link' => $link,
                'status' => false,
            ],
        );
    }

    /**
     * Handle JWTException
     *
     * @param string $message
     * @param string $trace
     * @return JsonResponse
     */
    protected function handleJwtError(string $message, string $trace): JsonResponse
    {
        return self::sendError(
            'JwtError. ' . $message,
            [
                'trace' => $trace,
                'status' => false,
            ],
        );
    }

    /**
     * Authenticate user
     *
     * @throws JWTException
     */
    protected function authenticateUser(string $token): JWTSubject
    {
        $user = JWTAuth::setToken($token)->authenticate();

        if (!$user) {
            throw new JWTException('Invalid token.');
        }

        return $user;
    }

    /**
     * Handle TokenExpiredException
     *
     * @return RedirectResponse|void
     * @throws JWTException
     */
    protected function handleTokenExpired()
    {
        try {
            $refreshedToken = JWTAuth::refresh();
        } catch (\Exception $e) {
            Log::error('Token Refresh Error: ' . $e->getMessage());
            Log::error('Token Refresh Stack Trace: ' . $e->getTraceAsString());
            throw new JWTException('Something went wrong while refreshing token');
        }

        try {
            $user = JWTAuth::setToken($refreshedToken)->toUser();
            $redirected = $this->checkAccess($user);

            if (!is_bool($redirected)) {
                return $redirected;
            }
        } catch (\Exception $e) {
            Log::error('Token Set Error: ' . $e->getMessage());
            Log::error('Token Set Stack Trace: ' . $e->getTraceAsString());
            throw new JWTException('Something went wrong while setting token');
        }
    }

    /**
     * Handle JWTException
     *
     * @param JWTException $e
     * @param string $message
     * @return JsonResponse
     */
    protected function handleJWTException(
        JWTException $e,
        string       $message,
    ): JsonResponse {
        Log::error(
            'Error while validating token: ' . $e->getMessage(),
            [
                'data' => [
                    $e->getTraceAsString(),
                ],
            ],
        );

        return $this->handleJwtError(
            $message,
            $e->getTraceAsString(),
        );
    }

    /**
     * Checking user access to resource
     *
     * @param JWTSubject $user User model
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector|bool
     */
    private function checkAccess(JWTSubject $user): bool|\Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        if (
            !$user->hasRole('reader')
        ) {
            return false;
        }

        return redirect(config('app.frontend_url'));
    }
}
