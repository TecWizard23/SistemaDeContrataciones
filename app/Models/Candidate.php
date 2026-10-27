<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'city',
        'summary',
        'experience_years',
        'education_level',
        'linkedin_url',
        'applied_position',
        'vacancy_id',
        'hiring_stage',
        'hiring_notes',
        'interview_scheduled_at',
        'hired_at',
    ];

    protected function casts(): array
    {
        return [
            'interview_scheduled_at' => 'datetime',
            'hired_at' => 'datetime',
            'experience_years' => 'integer',
        ];
    }

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(CandidateSession::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function isHired(): bool
    {
        return $this->hiring_stage === 'CONTRATADO' || !is_null($this->hired_at);
    }
}
