<?php

use App\Models\ActivityLog;

if (! function_exists('activity_log')) {
    function activity_log($action, $module = null, $description = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
        ]);
    }
}