<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebRTCOfferCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $liveId;
    public $offer;

    public function __construct($liveId, $offer)
    {
        $this->liveId = $liveId;
        $this->offer = $offer;
    }

    public function broadcastOn()
    {
        return new Channel('live.' . $this->liveId);
    }

    public function broadcastAs()
    {
        return 'webrtc.offer';
    }
}