<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;

    protected $table = 'push_notifications'; // ✅ match table name

    protected $casts = [
        'subscription' => 'array' // ✅ automatically converts JSON to array
    ];

    // protected $fillable = ['subscription']; // ✅ optional: if you're using mass assignment
}
