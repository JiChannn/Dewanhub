<?php
include('config.php');

// Ensure only logged-in users can access this page
checkLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Event - DewanHub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_mobile.css" media="only screen and (max-width: 600px)">
</head>
<body>
<div class="container fade-in">
    <div class="header">
        <img src="banner.png" alt="College Logo" class="logo">
    </div>
    <h2>Submit New Event</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="message" style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p class="message" style="color:green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>
    <form method="post" action="process_event.php">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" required rows="3"></textarea>

        <label for="event_start">Event Start (Date & Time)</label>
        <input type="datetime-local" name="event_start" id="event_start" required>

        <label for="event_end">Event End (Date & Time)</label>
        <input type="datetime-local" name="event_end" id="event_end" required>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    <div>
        <strong>Booked Slots Today:</strong>
        <ul>
        <?php
        $today = date('Y-m-d');
        $sql = "SELECT title, event_start, event_end FROM events WHERE DATE(event_start) = ? AND deleted_at IS NULL AND status = 'approved'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>" . htmlspecialchars($row['title']) . "</strong> &mdash; "
                . date('H:i', strtotime($row['event_start'])) . " - "
                . date('H:i', strtotime($row['event_end'])) . "</li>";
        }
        ?>
        </ul>
    </div>
    <p><a href="index.php">Back to Dashboard</a></p>
</div>
</body>
</html>
