<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    public function logActivity($action, $user, $key_id = null, $description = null)
    {
        Activity::create([
            'user_id' => $user->id,
            'key_id' => $key_id,
            'action' => $action,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
