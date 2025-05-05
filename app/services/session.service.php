<?php
return [
    "startSession" => function(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    },

    "setSession" => function(string $key, mixed $value): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[$key] = $value;
    },

    "getSession" => function(string $key): mixed {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION[$key] ?? null;
    },

    "unsetSession" => function(string $key): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    },

    "destroySession" => function(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = []; 
        session_destroy();
    }
];
