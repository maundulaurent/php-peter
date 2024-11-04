<?php
session_start([
    'cookie_lifetime' => 0, // Session cookie will last until the browser is closed
    'gc_maxlifetime' => 1800 // Optional: Set the maximum lifetime of session data in seconds
]);

// Set the idle timeout duration (in seconds)
$idleTimeout = 1200; // 20 minutes

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Check if the last activity timestamp is set
    if (isset($_SESSION['last_activity'])) {
        // Calculate the session duration
        $duration = time() - $_SESSION['last_activity'];
        
        // If the duration exceeds the idle timeout, destroy the session
        if ($duration > $idleTimeout) {
            session_unset(); // Unset session variables
            session_destroy(); // Destroy the session
            header('Location: login.php'); // Redirect to login page
            exit();
        }
    }

    // Update last activity timestamp
    $_SESSION['last_activity'] = time();
} else {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
?>
