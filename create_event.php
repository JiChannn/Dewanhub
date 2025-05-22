<?php
include('config.php');

// Ensure only logged-in users can access this page
checkLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_title       = trim($_POST['event_title']);
    $event_description = trim($_POST['event_description']);
    $event_date        = $_POST['event_date'];
    $user_id           = $_SESSION['user_id'];

    // Insert new event with default status 'pending'
    $stmt = $conn->prepare("INSERT INTO events (user_id, title, description, event_date, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isss", $user_id, $event_title, $event_description, $event_date);
    if ($stmt->execute()) {
        header("Location: index.php?message=Event+submitted+for+approval");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Event - DewanHub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_mobile.css" media="only screen and (max-width: 600px)">
</head>
<body>


    <div class="container fade-in">

        <div class="header">
            <img src="banner.png" alt="College Logo" class="logo">
        </div>

        <h2>Submit a New Event</h2>
        <form method="POST" action="">
            <label for="event_title">Event Title</label>
            <input type="text" name="event_title" id="event_title" required>
        
            <label for="event_description">Event Description</label>
            <textarea name="event_description" id="event_description" rows="4"></textarea>
        
            <label for="event_date">Event Date</label>
            <input type="date" name="event_date" id="event_date" required>
        
            <input type="submit" value="Submit Event">
        </form>
        
        <p><a href="index.php">Back to Dashboard</a></p>

        <table>
          <thead>
            <tr>
              <th>Event Title</th>
              <th>Description</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Fetch and display user's events
            $user_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("SELECT title, description, event_date, status FROM events WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['event_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }

            $stmt->close();
            ?>
          </tbody>
        </table>
    </div>
</body>
</html>
