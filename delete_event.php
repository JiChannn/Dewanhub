<?php
include 'config.php';

// Check kalau ada 'id' dalam URL dan pastikan ia adalah nombor
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Convert 'id' kepada integer

    // Query untuk 'soft delete' event (set deleted_at ke tarikh sekarang)
    $stmt = $conn->prepare("UPDATE events SET deleted_at = NOW() WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Kalau berjaya, redirect balik ke admin dashboard dengan mesej
        header("Location: admin_dashboard.php?message=Event+deleted");
        exit();
    } else {
        // Kalau ada error, tunjukkan error
        echo "Error deleting event: " . $stmt->error;
    }
    $stmt->close();
} else {
    // Kalau 'id' tak valid, tunjukkan mesej error
    echo "Invalid event ID.";
}
?>
