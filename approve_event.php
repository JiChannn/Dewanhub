<?php
include('config.php');

// Ensure only admins can access this page
checkUserRole('admin');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("UPDATE events SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()){
        header("Location: admin_dashboard.php?message=Event+approved");
        exit();
    } else {
        echo "Error approving event: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid event ID.";
}
?>
