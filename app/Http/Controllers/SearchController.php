<?php

namespace App\Http\Controllers;

use App\Events\TableACreated;
use App\Models\TableA;
use App\Models\User;
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

    public function checkPrices()
    {
        $response = Http::get('https://dummyjson.com/products');
        $products = $response->json()['products'];


        $users = User::all();


        foreach ($users as $user) {
            Mail::to($user->email)->send(new PriceNotificationMail($products));
        }

        return "Price check completed and emails sent.";

    }

    public function tablerecord()
    {
        $tableA = new TableA();
        $tableA->name = 'test';
        $tableA->user_star = 5;
        $tableA->save();
        
        event(new TableACreated($tableA));
    }
}
