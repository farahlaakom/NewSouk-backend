<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create([
            'product_id' => $request->product_id,
            'name'       => $request->name,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'city'       => $request->city,
            'status'     => 'pending',
        ]);

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order
        ]);
    }
}