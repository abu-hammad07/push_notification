<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationKey extends Model
{
    protected $fillable = ['vapid_public_key', 'vapid_private_key'];
}
