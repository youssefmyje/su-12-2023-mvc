<?php

namespace App\Utils;

class SessionManager
{
    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function destroySession()
    {
        if (session_status() != PHP_SESSION_NONE) {
            session_destroy();
        }
    }

    public function isAuthenticated()
    {
        $this->startSession();
        return isset($_SESSION['user']);
    }
}
