<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'evaluation_id',
        'status',
        'started_at',
        'completed_at',
        'raw_score',
        'fit_percentage',
        'metrics_summary',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'metrics_summary' => 'array',
        'raw_score' => 'float',
        'fit_percentage' => 'float',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(SessionAnswer::class);
    }
}
