<?php

namespace ESalnikov\Intetics\Core;

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function get(string $name)
    {
        return $_SESSION[$name] ?? null;
    }

    public function set(string $name, string $value): void
    {
        $_SESSION[$name] = $value;
    }

    public function unset(string $name): void
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }

    public function destroy(): void
    {
        if (isset($_SESSION)) {
            session_destroy();
        }
    }
}
