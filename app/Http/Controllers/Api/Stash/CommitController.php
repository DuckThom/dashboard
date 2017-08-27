<?php

namespace App\Http\Controllers\Api\Stash;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

/**
 * Stash commit controller.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class CommitController extends Controller
{
    /**
     * Get the Zegro ESB commits.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function zegroEsb(Request $request)
    {
       return $this->callAPI("/rest/api/1.0/projects/ZEG/repos/esb-zegro/commits", $request->input('from', null));
    }

    /**
     * Get the Zegro Magento commits.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function zegroMagento(Request $request)
    {
        return $this->callAPI("/rest/api/1.0/projects/ZEG/repos/magento-zegro/commits", $request->input('from', null));
    }

    /**
     * Call the api endpoint.
     *
     * @param  string  $endpoint
     * @param  string|null  $from
     * @return \Illuminate\Http\JsonResponse
     */
    protected function callAPI(string $endpoint, string $from = null)
    {
        \Log::debug($from);
        $client = new Client();

        try {
            $response = $client->get(config('stash.host') . $endpoint, [
                'query' => [
                    'limit' => 10,
                    'since' => $from
                ],
                'headers' => [
                    'Accept'     => 'application/json',
                ],
                'auth' => [
                    config('stash.username'),
                    config('stash.password')
                ]
            ]);

            $code = $response->getStatusCode();
            $payload = json_decode($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            \Log::warning($e->getMessage());

            $code = $e->getResponse()->getStatusCode();

            if ($code === 401) {
                \Log::debug('Stash API auth failure.');
            }

            $payload = [
                "message" => "Loading from Stash API failed.",
            ];
        }

        return response()->json([
            'code' => $code,
            'success' => $code >= 200 && $code < 300,
            'payload' => $payload
        ]);
    }
}