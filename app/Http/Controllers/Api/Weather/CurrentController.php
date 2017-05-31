<?php

namespace App\Http\Controllers\Api\Weather;

use GuzzleHttp\Exception\TransferException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 * Current weather controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class CurrentController extends Controller
{
    /**
     * Get the current weather data
     *
     * @param  Request  $request
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client)
    {
        if (cache()->has('weather/current')) {
            \Log::info('Loading weather data from cache');

            return response()->json([
                'message' => '',
                'payload' => json_decode(cache('weather/current'))
            ]);
        }

        try {
            $response = $client->get('http://api.openweathermap.org/data/2.5/weather', [
                'query' => [
                    'appid' => config('owm.key'),
                    'q' => 'Aduard,nl',
                    'lang' => app()->getLocale()
                ]
            ]);
        } catch (TransferException $e) {
            \Log::error($e);

            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        $json = $response->getBody()->getContents();

        cache()->put('weather/current', $json, 10);

        return response()->json([
            'message' => '',
            'payload' => json_decode($json)
        ]);
    }
}