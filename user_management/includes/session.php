<?php

declare(strict_types=1);

if (!defined('LOGIN_IDLE_SECONDS')) {
    define('LOGIN_IDLE_SECONDS', 60);
}

if (!function_exists('is_request_https')) {
    function is_request_https(): bool
    {
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            return true;
        }
        if ($proto = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) {
            return strtolower($proto) === 'https';
        }
        return isset($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443';
    }
}

/**
 * SameSite cookie options require PHP 7.3+ — older versions use positional setcookie().
 */
if (!function_exists('set_cookie_compat')) {
    function set_cookie_compat(
        string $name,
        string $value,
        int $expires,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httponly = true
    ): void {
        if (PHP_VERSION_ID >= 70300) {
            setcookie($name, $value, [
                'expires' => $expires,
                'path' => $path,
                'domain' => $domain,
                'secure' => $secure,
                'httponly' => $httponly,
                'samesite' => 'Lax',
            ]);
            return;
        }
        setcookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }
}

if (!function_exists('refresh_idle_cookie')) {
    function refresh_idle_cookie(): void
    {
        $secure = is_request_https();
        set_cookie_compat(
            'login_idle',
            'active',
            time() + LOGIN_IDLE_SECONDS,
            '/',
            '',
            $secure,
            true
        );
    }
}

if (!function_exists('clear_idle_cookie')) {
    function clear_idle_cookie(): void
    {
        $secure = is_request_https();
        set_cookie_compat(
            'login_idle',
            '',
            time() - 3600,
            '/',
            '',
            $secure,
            true
        );
    }
}

if (session_status() !== PHP_SESSION_NONE) {
    return;
}

$secureCookies = is_request_https();

if (PHP_VERSION_ID >= 70300) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secureCookies,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
} else {
    session_set_cookie_params(0, '/', '', $secureCookies, true);
}

if (PHP_VERSION_ID >= 70000) {
    session_start(['use_strict_mode' => true]);
} else {
    @ini_set('session.use_strict_mode', '1');
    session_start();
}
