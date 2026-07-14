<?php

namespace App\Http\Controllers;

use App\Models\LiveSession;
use Illuminate\Http\Request;
use App\Events\LiveStarted;

class LiveSessionController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $live = LiveSession::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'is_live' => true
        ]);
        event(new LiveStarted($live));

        return response()->json([
            'message' => 'Live started',
            'live' => $live
        ], 201);
    }


    public function stop($id)
    {
        $live = LiveSession::find($id);

        if (!$live) {
            return response()->json([
                'message' => 'Live not found'
            ],404);
        }

        $live->update([
            'is_live' => false
        ]);

        return response()->json([
            'message' => 'Live stopped'
        ]);
    }
    public function index()
{
    return response()->json(
        LiveSession::with(['product.category'])
            ->where('is_live', true)
            ->latest()
            ->get()
    );
}
}
