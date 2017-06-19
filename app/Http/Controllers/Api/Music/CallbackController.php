<?php

namespace App\Http\Controllers\Api\Music;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Callback controller.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class CallbackController extends Controller
{
    /**
     * Handle the Spotify API callback.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if (app('spotify')->requestAccessToken($request->input('code'))) {
            $accessToken = app('spotify')->getAccessToken();
            $accessTokenTimeout = app('spotify')->getTokenExpiration();
            $refreshToken = app('spotify')->getRefreshToken();

            session()->put('spotify.access_token', $accessToken);
            session()->put('spotify.access_token_timeout', $accessTokenTimeout);
            session()->put('spotify.refresh_token', $refreshToken);
        }

        return redirect('/');
    }
}