<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Spotify access token middleware.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class CheckSpotifyAccessTokenTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('spotify.access_token') && session()->has('spotify.access_token_timeout') && session()->has('spotify.refresh_token')) {
            if (session('spotify.access_token_timeout') > (time() - 60)) {
                return $next($request);
            } else {
                if (session('spotify.refresh_token') !== "") {
                    if (app('spotify')->refreshAccessToken(session('spotify.refresh_token'))) {
                        $accessToken = app('spotify')->getAccessToken();
                        $accessTokenTimeout = app('spotify')->getTokenExpiration();
                        $refreshToken = app('spotify')->getRefreshToken();

                        session()->put('spotify.access_token', $accessToken);
                        session()->put('spotify.access_token_timeout', $accessTokenTimeout);
                        session()->put('spotify.refresh_token', $refreshToken);

                        return $next($request);
                    }
                }
            }
        }

        return $next($request);
    }
}