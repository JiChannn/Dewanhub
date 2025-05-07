<?php
include 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("UPDATE events SET status = 'completed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()){
        header("Location: admin_dashboard.php?message=Event+marked+complete");
        exit();
    } else {
        echo "Error marking event as complete: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid event ID.";
}
?>
