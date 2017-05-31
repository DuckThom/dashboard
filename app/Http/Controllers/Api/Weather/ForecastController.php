<?php

namespace App\Http\Controllers\Api\Weather;

use GuzzleHttp\Exception\TransferException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 * Weather forecast controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class ForecastController extends Controller
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
        if (cache()->has('weather/forecast')) {
            \Log::info('Loading weather forecast data from cache');

            return response()->json([
                'message' => '',
                'payload' => json_decode(cache('weather/forecast'))
            ]);
        }

        try {
            $response = $client->get('http://api.openweathermap.org/data/2.5/forecast/daily', [
                'query' => [
                    'appid' => config('owm.key'),
                    'q' => 'Aduard,nl'
                ]
            ]);
        } catch (TransferException $e) {
            \Log::error($e);

            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        $json = $response->getBody()->getContents();

        cache()->put('weather/forecast', $json, 10);

        return response()->json([
            'message' => '',
            'payload' => json_decode($json)
        ]);
    }
}