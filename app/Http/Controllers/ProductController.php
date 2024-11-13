<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data


        // dd($request);
        $validated = $request->validate([
            'days' => 'required|integer|min:1',
            'server' => 'required',
            'trxID' => 'required|string',
        ]);


        $server = Server::find($validated['server']);
        $service_charge = 5;
        $productData = [
            'user_id' => Auth::user()->id,
            'server_id' => $server->id,
            'base_price' => $server->provider_price,
            'product_type' => 'server',
            'trxID' => $validated['trxID'],
            'durations' => $validated['days'],
            'total_price' => $server->provider_price * $validated['days'] + $service_charge, 
        ];

        // Create a new order or perform any other necessary actions
        $product = Product::create($productData);
        dd($product);
        // Redirect back or return a response
        return redirect()->back();
    }
}
