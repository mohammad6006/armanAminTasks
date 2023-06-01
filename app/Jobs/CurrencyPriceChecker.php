<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\CurrencyPriceNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CurrencyPriceChecker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::get('https://dummyjson.com/products');
        $products = $response->json()['products'];

        foreach ($products as $product) {
            $users = User::all();

            foreach ($users as $user) {
                $user->notify(new CurrencyPriceNotification($product['title'], $product['price']));
            }
        }
    }
}
