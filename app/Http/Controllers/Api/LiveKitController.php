<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;

class LiveKitController extends Controller
{
    public function token(Request $request)
{
    $room = $request->input('room');
    $identity = $request->input('identity', 'viewer');

    if (!$room) {
        return response()->json([
            'message' => 'Room is required'
        ], 400);
    }

    $options = new AccessTokenOptions([
        'identity' => $identity,
        'name' => $identity,
    ]);

    $grant = new VideoGrant();

    $grant->setRoomJoin(true);
    $grant->setRoomName($room);

    $token = new AccessToken(
        env('LIVEKIT_API_KEY'),
        env('LIVEKIT_API_SECRET'),
        $options
    );

    $token->setGrant($grant);

    return response()->json([
        'token' => $token->toJwt(),
        'room' => $room,
        'identity' => $identity
    ]);
}
}