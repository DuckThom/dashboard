<?php

namespace App\Http\Controllers\Api\Music;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Playing controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class PlayingController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $client = new Client();

        try {
            $response = $client->get("https://api.spotify.com/v1/me/player/currently-playing", [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('spotify.access_token')
                ]
            ]);
            $code = $response->getStatusCode();
            $payload = $response->getBody()->getContents();
        } catch (BadResponseException $e) {
            $code = $e->getResponse()->getStatusCode();
            $payload = [
                "message" => "Loading from Spotify API failed.",
            ];
        }

        return response()->json([
            'code' => $code,
            'success' => $code >= 200 && $code < 300,
            'payload' => $payload
        ]);
    }
}