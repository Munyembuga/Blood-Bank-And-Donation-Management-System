<?php
// Output buffering should already be started by conn.php
// But check just in case
if (ob_get_level() == 0) ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
