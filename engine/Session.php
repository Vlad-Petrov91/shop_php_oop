<?php

namespace app\engine;

class Session
{
    public function __set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function __get($key)
    {
        return $_SESSION[$key];
    }

    public function destroy()
    {
        session_destroy();
    }

    public function regenerate()
    {
        session_regenerate_id();
    }

    public function getId()
    {
        return session_id();
    }
}