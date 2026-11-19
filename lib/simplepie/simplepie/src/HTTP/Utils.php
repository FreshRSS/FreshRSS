<?php

declare(strict_types=1);

namespace SimplePie\HTTP;

/**
 * HTTP util functions
 * FreshRSS
 * @internal
 */
final class Utils
{
    /**
     * Extracts `max-age` from the `Cache-Control` HTTP headers
     *
     * @param array<string,mixed> $http_headers HTTP headers of the response
     * @return int|null The `max-age` value or `null` if not found
     *
     * FreshRSS
     */
    public static function get_http_max_age(array $http_headers): ?int
    {
        $cache_control = $http_headers['cache-control'] ?? null;
        if (is_string($cache_control) && preg_match('/\bmax-age=(\d+)\b/', $cache_control, $matches)) {
            return (int) $matches[1];
        }
        return null;
    }

    /**
     * Negotiate the cache expiration time based on the HTTP response headers.
     * Return the cache duration time in number of seconds since the Unix Epoch, accounting for:
     * - `Cache-Control: max-age` minus `Age`, bounded by `$cache_duration_min` and `$cache_duration_max`
     * - `Cache-Control: must-revalidate` will set `$cache_duration` to `$cache_duration_min`
     * - `Cache-Control: no-cache` will return `time() + $cache_duration_min`
     * - `Cache-Control: no-store` will return `time() + $cache_duration_min - 3`
     * - `Expires` like `Cache-Control: max-age` but only if it is absent
     *
     * @param array<string,mixed> $http_headers HTTP headers of the response
     * @param int $cache_duration Desired cache duration in seconds, potentially overridden by HTTP response headers
     * @param int $cache_duration_min Minimal cache duration (in seconds), overriding HTTP response headers `Cache-Control` and `Expires`,
     * @param int $cache_duration_max Maximal cache duration (in seconds), overriding HTTP response headers `Cache-Control: max-age` and `Expires`,
     * @return int The negotiated cache expiration time in seconds since the Unix Epoch
     *
     * FreshRSS
     */
    public static function negociate_cache_expiration_time(array $http_headers, int $cache_duration, int $cache_duration_min, int $cache_duration_max): int
    {
        $cache_control = $http_headers['cache-control'] ?? '';
        if ($cache_control !== '') {
            if (preg_match('/\bno-store\b/', $cache_control)) {
                return time() + $cache_duration_min - 3; // -3 to distinguish from no-cache if needed
            }
            if (preg_match('/\bno-cache\b/', $cache_control)) {
                return time() + $cache_duration_min;
            }
            if (preg_match('/\bmust-revalidate\b/', $cache_control)) {
                $cache_duration = $cache_duration_min;
            }
            if (preg_match('/\bmax-age=(\d+)\b/', $cache_control, $matches)) {
                $max_age = (int) $matches[1];
                $age = $http_headers['age'] ?? '';
                if (is_numeric($age)) {
                    $max_age -= (int) $age;
                }
                return time() + min(max($max_age, $cache_duration), $cache_duration_max);
            }
        }
        $expires = $http_headers['expires'] ?? '';
        if ($expires !== '') {
            $expire_date = \SimplePie\Misc::parse_date($expires);
            if ($expire_date !== false) {
                return min(max($expire_date, time() + $cache_duration), time() + $cache_duration_max);
            }
        }
        return time() + $cache_duration;
    }
}
