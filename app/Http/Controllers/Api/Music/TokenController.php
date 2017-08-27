<?php

namespace App\Http\Controllers\Api\Music;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * Token controller.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class TokenController extends Controller
{
    /**
     * TokenController constructor.
     */
    public function __construct()
    {
        $this->middleware('spotify');
    }

    /**
     * Get a token for the frontend.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if (session('spotify.access_token') && session('spotify.access_token_timeout') > (time() - 60)) {
            return response([
                'payload' => [
                    'token' => session('spotify.access_token')
                ]
            ]);
        } else {
            return response([
                'payload' => [
                    'authUrl' => app('spotify')->getAuthorizeUrl([
                        'scope' => config('spotify.scopes')
                    ])
                ]
            ]);
        }
    }
}