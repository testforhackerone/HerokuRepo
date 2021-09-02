<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

trait IssueTokenTrait
{

    private $client;
    private $cookie;

    public function __construct(Application $app)
    {
        $this->client = Client::find(env('MOBILE_CLIENT_ID', 2));
        $this->cookie = $app->make('cookie');
    }

    public function issueToken(Request $request, $grantType, $scope = "*")
    {
        $params = [
            'grant_type' => $grantType,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => $scope
        ];

        if ($grantType !== 'social') {
            $params['username'] = $request->email ?: $request->username;
        }

        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST', $request->all());
//        $r = Route::dispatch($proxy);
//        dd($r);
        return Route::dispatch($proxy);

    }

    /**
     * @param $response
     * @param array $array
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($response, $array = [])
    {
        if (empty($array)) {
            return $response;
        }

        $data = json_decode($response->getContent());

        $newResponse = [
            'token_type' => $data->token_type,
            'expires_in' => $data->expires_in,
            'access_token' => $data->access_token,
            'refresh_token' => $data->refresh_token,
        ];

        foreach ($array as $key => $value) {
            $newResponse[$key] = $value;
        }

        return response()->json($newResponse);
    }

}