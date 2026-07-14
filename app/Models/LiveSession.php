<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'is_live'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}