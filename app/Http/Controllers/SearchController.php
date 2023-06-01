<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SearchController extends Controller
{
    public function searchMovie(Request $request)
    {
        $q = $request->q;
        $page = $request->page;

        $cacheKey = 'search:' . $q . ':' . $page;

        if (Redis::exists($cacheKey)) {

            $results = Redis::get($cacheKey);
            $results = json_decode($results, true);

        } else {

            $client = new Client();
    

            $response = $client->request('GET', 'http://moviesapi.ir/api/v1/movies', [
                'query' => [
                    'q' => $q,
                    'page' => $page,
                ],
            ]);
    

            $body = $response->getBody();
    

            $results = json_decode($body, true);
    

            Redis::set($cacheKey, $body);
            Redis::expire($cacheKey, 60);
        }
    

        return response()->json($results);

    }
}
