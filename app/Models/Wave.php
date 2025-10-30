<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wave extends Model
{
    use HasFactory;

    /**
     * Table name in the database
     */
    protected $table = 'waves';

    /**
     * Fillable columns for mass assignment
     */
    protected $fillable = [
        'wave_name',
        'start_date',
        'end_date',
        'participant_quota',
        'status',
    ];

    /**
     * Column casting
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'participant_quota' => 'integer',
    ];

    /**
     * Check if the wave is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Scope for active waves
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for available waves (still ongoing)
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')
                     ->where('end_date', '>=', now());
    }
}
