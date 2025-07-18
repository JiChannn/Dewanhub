<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

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

// Prepare HTML for PDF
$html = '
    <h2 style="text-align:center;">Event Details</h2>
    <table style="width:100%;border-collapse:collapse;">
        <tr><td style="font-weight:bold;">Title:</td><td>' . htmlspecialchars($event['title']) . '</td></tr>
        <tr><td style="font-weight:bold;">Description:</td><td>' . htmlspecialchars($event['description']) . '</td></tr>
        <tr><td style="font-weight:bold;">Start:</td><td>' . htmlspecialchars($event['event_start']) . '</td></tr>
        <tr><td style="font-weight:bold;">End:</td><td>' . htmlspecialchars($event['event_end']) . '</td></tr>
        <tr><td style="font-weight:bold;">Submitted By:</td><td>' . htmlspecialchars($event['username']) . '</td></tr>

    </table>
';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("event_{$id}.pdf", ["Attachment" => true]);
exit;
?>