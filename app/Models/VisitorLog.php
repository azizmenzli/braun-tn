<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address', 'country', 'city', 'latitude', 'longitude',
        'os', 'browser', 'device', 'referer', 'visited_page', 'visit_time'
    ];
}