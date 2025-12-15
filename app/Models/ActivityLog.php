<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'subject_id',
        'subject_type',
    ];

    /**
     * Create a new activity log entry.
     *
     * @param string $action
     * @param string $description
     * @param Model $subject
     * @return void
     */
    public static function log(string $action, string $description, Model $subject): void
    {
        self::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'subject_id' => $subject->id,
            'subject_type' => get_class($subject),
        ]);
    }

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model that was the subject of the action.
     */
    public function subject()
    {
        return $this->morphTo();
    }
}