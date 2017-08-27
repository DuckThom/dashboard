<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\TransferException;

/**
 * News controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class NewsController extends Controller
{
    /**
     * Tweakers:    http://feeds.feedburner.com/tweakers/mixed
     * Nu.nl:       http://www.nu.nl/rss
     */
    const NEWS_URL = 'http://www.nu.nl/rss';

    /**
     * Relay an XML RSS feed to a client in JSON.
     *
     * @param  Request  $request
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client)
    {
        try {
            $response = $client->get(self::NEWS_URL);
        } catch (TransferException $e) {
            \Log::error($e);

            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return response()->json([
            'message' => '',
            'payload' => simplexml_load_string($response->getBody()->getContents())
        ]);
    }
}