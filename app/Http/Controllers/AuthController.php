<?php

namespace App\Http\Controllers;

use App\Enums\AuthIntEnum;
use App\Enums\AuthStrEnum;
use App\Exceptions\JwtException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @const int
     * User id for auth in local environment.
     */
    private const LOCAL_USER_ID = 1;

    /**
     * @const string
     * Path to api auth.
     */
    private const API_AUTH_PATH = '/api/auth';

    /**
     * @const string
     * Path to api logout.
     */
    private const API_LOGOUT_PATH = '/api/logout';

    /**
     * @const string
     * Path to admin dashboard.
     */
    private const ADMIN_AUTH_PATH = '/admin';

    /**
     * Get the authenticated User.
     *
     * @throws JwtException
     */
    public function user(): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (config('app.env') === 'local') {
            return $this->login(self::LOCAL_USER_ID);
        }

        $url = config('app.api_url') . self::API_AUTH_PATH;

        $response = Http::withHeaders(
            [
                'Referer' => config('app.url'),
                'Authorization' => Cookie::get(
                    config('app.env')
                    . '_'
                    . AuthStrEnum::JWT_NAME->value,
                ),
            ],
        )
            ->get($url)
            ->json();

        if (!isset($response['data'])) {
            Log::error('There is no data in response for jwt auth', ['response' => $response]);
            throw new JwtException('There is no data in response for jwt auth');
        }

        if ($response['data']['status']) {
            return $this->login($response['data']['user']['id']);
        }

        if (!isset($response['data']['link'])) {
            throw new JwtException('There is no link in response for jwt auth');
        }

        return redirect($response['data']['link'])
            ->withCookie(
                config('app.env')
                . '_'
                . AuthStrEnum::SOURCE_COOKIE->value,
                config('app.url'),
                AuthIntEnum::EXPIRED->value,
                AuthStrEnum::JWT_PATH->value,
                AuthStrEnum::JWT_DOMAIN->value,
                true, // secure
                false, // httpOnly
                AuthStrEnum::SAME_SITE->value // sameSite
            );
    }

    /**
     * Login the user.
     *
     * @param int $userId
     * @return Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function login(int $userId): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        Auth::loginUsingId($userId);

        return redirect(self::ADMIN_AUTH_PATH);
    }

    /**
     * Logout the user.
     *
     * @return Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function logout(): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (config('app.env') === 'local') {
            return redirect('/');
        }

        return redirect(config('app.api_redirect_url') . self::API_LOGOUT_PATH)->withCookie(
            config('app.env')
            . '_'
            . AuthStrEnum::SOURCE_COOKIE->value,
            config('app.url'),
            AuthIntEnum::EXPIRED->value,
            AuthStrEnum::JWT_PATH->value,
            AuthStrEnum::JWT_DOMAIN->value,
            true, // secure
            false, // httpOnly
            AuthStrEnum::SAME_SITE->value // sameSite
        );
    }
}
