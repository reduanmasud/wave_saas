<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class ServerTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('servers')->delete();

        $apiKey = env('VULTR_API_KEY');

        $response = Http::withToken($apiKey)->get('https://api.vultr.com/v2/plans');

        if ($response->successful()) {
            $jsonResponse = $response->json();
            $plans = $jsonResponse['plans'];
            $selectedPlans  = Arr::where($plans, fn($plan) => str_starts_with($plan['id'], 'vc2') && !strrpos($plan['id'], 'sc1') && !strrpos($plan['id'], 'free'));
        } else {
            // Handle errors
            return response()->json([
                'error' => 'Failed to fetch plans',
                'details' => $response->body()
            ], $response->status());
        }

        $count = 1;
        foreach ($selectedPlans as $plan) {
            $providerPrice = ceil(($plan['monthly_cost'] / 30) * 125);
            $price = $providerPrice + $providerPrice * 0.5;
            DB::table('servers')->insert(array(
                'server_name' => 'Server '.$count++,
                'slug'  => $plan['id'],
                'ram'   => $plan['ram'] / 1024,
                'vcpu'  => $plan['vcpu_count'],
                'disk_storage'  => $plan['disk'],
                'server_provider'   => 'VULTR',
                'provider_price'    => $price,
                'hourly_price' => $price/24,
                'created_at' => now(),
                'updated_at' => now(),
            ));
        }
    }
}
