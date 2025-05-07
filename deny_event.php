<?php
include 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("UPDATE events SET status = 'denied' WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()){
        header("Location: admin_dashboard.php?message=Event+denied");
        exit();
    } else {
        echo "Error denying event: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid event ID.";
}
?>
