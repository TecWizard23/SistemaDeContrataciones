<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department',
        'location',
        'contract_type',
        'openings_count',
        'status',
        'salary_range',
        'description',
        'requirements',
        'closing_date',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'closing_date' => 'date',
            'openings_count' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function candidates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * Scope for open vacancies.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'OPEN');
    }
}
