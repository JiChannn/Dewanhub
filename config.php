<?php
// Start session hanya kalau belum dimulakan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
$servername   = "localhost";
$db_username  = "root";
$db_password  = "";  // Password MySQL (kosong untuk XAMPP)
$dbname       = "dewan_events";

// Buat connection ke database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character encoding ke UTF-8 untuk support internationalization
$conn->set_charset("utf8mb4");

// Helper function untuk check role user dan redirect kalau tak sesuai
function checkUserRole($requiredRole, $redirectPage = 'login.php') {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== $requiredRole) {
        header("Location: $redirectPage");
        exit();
    }
}

// Helper function untuk check kalau user dah login
function checkLoggedIn($redirectPage = 'login.php') {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: $redirectPage");
        exit();
    }
}
?>
