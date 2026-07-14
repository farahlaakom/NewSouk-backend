<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('live.{productId}', function ($user, $productId) {
    return true;
});