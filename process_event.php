<?php
include('config.php');
session_start();

// Ensure only logged-in users can access this page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_start = $_POST['event_start'];
    $event_end = $_POST['event_end'];
    $user_id = $_SESSION['user_id'];

    // Prevent invalid time range
    if (strtotime($event_end) <= strtotime($event_start)) {
        $error = "End time must be after start time!";
        header("Location: create_event.php?error=" . urlencode($error));
        exit;
    }

    // Check for any approved event with overlapping time
    $sql = "SELECT id FROM events 
            WHERE deleted_at IS NULL
            AND status = 'approved'
            AND (event_start < ? AND event_end > ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $event_end, $event_start);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Slot already booked for this date and time!";
        header("Location: create_event.php?error=" . urlencode($error));
        exit;
    } else {
        // Auto-approve event
        $sql = "INSERT INTO events (title, description, event_start, event_end, user_id, status) VALUES (?, ?, ?, ?, ?, 'approved')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $description, $event_start, $event_end, $user_id);
        if ($stmt->execute()) {
            $success = "Event submitted and auto-approved!";
            header("Location: index.php?success=" . urlencode($success));
            exit;
        } else {
            $error = "Failed to submit event.";
            header("Location: create_event.php?error=" . urlencode($error));
            exit;
        }
    }
} else {
    header("Location: create_event.php");
    exit;
}
?>