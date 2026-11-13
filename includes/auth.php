<?php
/**
 * includes/auth.php - session + role gate + CSRF protection for dashboard entry points.
 * Included by dashboard.php (admin) and staff_dashboard.php (staff).
 */

function requireAuth(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header('Location: signin.php');
        exit;
    }
}

function requireRole(string $role): void
{
    requireAuth();
    if (($_SESSION['role'] ?? '') !== $role) {
        header('Location: signin.php');
        exit;
    }
}

function logout(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION = [];
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
}

function noCache(): void
{
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() - 86400) . ' GMT');
}

// ── CSRF token helpers ────────────────────────────────────────────────────────

function csrfToken(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') . '">';
}

function validateCsrf(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $postToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';
    if ($postToken === '' || $sessionToken === '' || !hash_equals($sessionToken, $postToken)) {
        return false;
    }
    return true;
}
