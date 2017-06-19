<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Exception\TransferException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 * News controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class NewsController extends Controller
{
    /**
     * Get the news from the tweakers rss feed
     *
     * @param  Request  $request
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client)
    {
        try {
            $response = $client->get('http://feeds.feedburner.com/tweakers/mixed');
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