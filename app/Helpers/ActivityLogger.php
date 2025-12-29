<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log Create Activity
     */
    public static function logCreate($model, $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?? "Created new {$modelName}";
        
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'create',
            'model' => $modelName,
            'model_id' => $model->id,
            'description' => $desc,
            'new_values' => $model->toArray(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }

    /**
     * Log Update Activity
     */
    public static function logUpdate($model, $oldValues, $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?? "Updated {$modelName}";
        
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'update',
            'model' => $modelName,
            'model_id' => $model->id,
            'description' => $desc,
            'old_values' => $oldValues,
            'new_values' => $model->toArray(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }

    /**
     * Log Delete Activity
     */
    public static function logDelete($model, $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?? "Deleted {$modelName}";
        
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'delete',
            'model' => $modelName,
            'model_id' => $model->id,
            'description' => $desc,
            'old_values' => $model->toArray(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }

    /**
     * Log Login Activity
     */
    public static function logLogin($user)
    {
        return ActivityLog::create([
            'user_id' => $user->id,
            'type' => 'login',
            'description' => "User {$user->name} logged in",
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }

    /**
     * Log Logout Activity
     */
    public static function logLogout()
    {
        $user = Auth::user();
        
        // Check if user exists before logging
        if (!$user) {
            return null;
        }
        
        return ActivityLog::create([
            'user_id' => $user->id,
            'type' => 'logout',
            'description' => "User {$user->name} logged out",
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }

    /**
     * Log Custom Activity
     */
    public static function log($type, $description, $model = null, $modelId = null, $oldValues = null, $newValues = null)
    {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => $type,
            'model' => $model ? class_basename($model) : null,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }
}