<?php
include('config.php');

// Ensure only logged-in users can access this page
checkLoggedIn();

$username = $_SESSION['username'];
$role = $_SESSION['role']; // Get the user's role
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard - DewanHub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_mobile.css" media="only screen and (max-width: 600px)">
</head>
<body>

<div class="container fade-in">
    <div class="header">
        <img src="banner.png" alt="College Logo" class="logo">
    </div>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <p>
        <a href="create_event.php">Submit New Event</a> |
        <a href="logout.php" class="logout-link">Logout</a>
        <?php if ($role === 'admin'): ?>
            | <a href="admin_dashboard.php">Go to Admin Dashboard</a>
        <?php endif; ?>
    </p>
    
    <!-- Section 1: All Approved Events (Visible to All Users) -->
    <h3>Approved Events</h3>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        
        <tbody>

            <?php
            // Query to fetch all events with status 'approved'
            // Removing the event_date condition so that both past and upcoming events are displayed
            $sqlApproved = "SELECT * FROM events WHERE status = 'approved' AND deleted_at IS NULL ORDER BY event_date ASC";
            $resultApproved = mysqli_query($conn, $sqlApproved);
            if ($resultApproved && mysqli_num_rows($resultApproved) > 0) {
                while ($row = mysqli_fetch_assoc($resultApproved)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                        <td>" . htmlspecialchars($row['event_date']) . "</td>
                        <td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No approved events found.</td></tr>";
            }
            ?>
            
        </tbody>
    </table>
    
    <!-- Section 2: My Submitted Events -->
    <h3>My Submitted Events</h3>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $user_id = $_SESSION['user_id'];
            $sqlMine = "SELECT * FROM events WHERE user_id = $user_id AND deleted_at IS NULL ORDER BY event_date DESC";
            $resultMine = mysqli_query($conn, $sqlMine);
            if ($resultMine && mysqli_num_rows($resultMine) > 0) {
                while ($row = mysqli_fetch_assoc($resultMine)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                        <td>" . htmlspecialchars($row['event_date']) . "</td>
                        <td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>You haven't submitted any events yet.</td></tr>";
            }
            ?>
            
        </tbody>
    </table>
</div>

<script src="script.js"></script>
</body>
</html>
