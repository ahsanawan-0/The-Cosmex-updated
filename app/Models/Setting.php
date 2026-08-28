<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Throwable;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Per-request cache of every settings row, keyed by `key`. */
    protected static ?array $cache = null;

    /**
     * Resolve a setting.
     *
     * Falls back to the explicit $default, then to config/site.php, so a row
     * that is missing or blank never leaks a placeholder onto the site.
     */
    public static function get($key, $default = null)
    {
        $value = static::all_settings()[$key] ?? null;

        if ($value === null || $value === '') {
            return $default ?? config('site.' . $key);
        }

        return $value;
    }

    public static function set($key, $value)
    {
        static::$cache = null;

        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /** Load all settings once per request; tolerate a missing table pre-migration. */
    protected static function all_settings(): array
    {
        if (static::$cache === null) {
            try {
                static::$cache = self::query()->pluck('value', 'key')->all();
            } catch (Throwable $e) {
                static::$cache = [];
            }
        }

        return static::$cache;
    }
}
