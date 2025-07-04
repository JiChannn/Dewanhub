<?php
include 'config.php';

// Get event ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid event ID.";
    exit;
}
$id = intval($_GET['id']);

// Fetch event details
$stmt = $conn->prepare("SELECT events.*, users.username FROM events JOIN users ON events.user_id = users.id WHERE events.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    echo "Event not found.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Print Event - DewanHub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff; color: #222; }
        .container { max-width: 500px; margin: 40px auto; padding: 24px; border: 1px solid #ccc; border-radius: 10px; }
        h2 { text-align: center; }
        .label { font-weight: bold; }
        .row { margin-bottom: 12px; }
        @media print {
            body { background: #fff !important; }
            .container { border: none; box-shadow: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h2>Event Details</h2>
        <div class="row"><span class="label">Title:</span> <?= htmlspecialchars($event['title']) ?></div>
        <div class="row"><span class="label">Description:</span> <?= htmlspecialchars($event['description']) ?></div>
        <div class="row"><span class="label">Start:</span> <?= htmlspecialchars($event['event_start']) ?></div>
        <div class="row"><span class="label">End:</span> <?= htmlspecialchars($event['event_end']) ?></div>
        <div class="row"><span class="label">Submitted By:</span> <?= htmlspecialchars($event['username']) ?></div>
        <div class="row"><span class="label">Status:</span> <?= htmlspecialchars(ucfirst($event['status'])) ?></div>
    </div>
</body>
</html>