<?php

namespace App\Models;

use App\Enums\VacationType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'user_full_name',
        'honorable_reason_type',
        'honorable_reason_dates'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function working_schedule(): BelongsTo
    {
        return $this->belongsTo(WorkingSchedule::class);
    }

    public function userFullName(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->user->full_name
        );
    }

    public function honorableReasonType(): Attribute
    {
        return new Attribute(
            get: fn($value) => VacationType::getData($this->reason_type)
        );
    }

    public function honorableReasonDates(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($this->start_date)->format('d.m.Y').' - '.Carbon::parse($this->end_date)->format('d.m.Y')
        );
    }

    public function formattedStartDate(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($this->start_date)->format('d.m.Y')
        );
    }

    public function formattedEndDate(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($this->end_date)->format('d.m.Y')
        );
    }

    public function diffDays(): Attribute
    {
        $diffDays = Carbon::parse($this->start_date)->diffInDays($this->end_date);
        return new Attribute(
            get: fn($value) => ($diffDays == 0) ? 1 : $diffDays
        );
    }

    public function formattedCreateDate(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->created_at)->format('d.m.Y')
        );
    }
}
