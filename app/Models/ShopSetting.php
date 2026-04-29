<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopSetting extends Model
{
    protected $fillable = [
        'is_open', 'use_schedule', 'opening_time', 'closing_time', 'custom_message',
    ];

    protected $casts = [
        'is_open'      => 'boolean',
        'use_schedule' => 'boolean',
    ];

    /** Always returns the single settings row, creating it if missing. */
    public static function instance(): self
    {
        return self::firstOrCreate([], [
            'is_open'        => true,
            'use_schedule'   => false,
            'opening_time'   => '06:00',
            'closing_time'   => '22:00',
            'custom_message' => null,
        ]);
    }

    /** Computed: is the shop actually open right now? */
    public function effectivelyOpen(): bool
    {
        // Admin manually closed
        if (!$this->is_open) return false;

        // Auto schedule enabled — check time
        if ($this->use_schedule) {
            $now   = now()->format('H:i');
            $open  = $this->opening_time;
            $close = $this->closing_time;

            // Handle overnight (e.g. 22:00 – 02:00)
            if ($close < $open) {
                return $now >= $open || $now < $close;
            }
            return $now >= $open && $now <= $close;
        }

        return true;
    }
}
