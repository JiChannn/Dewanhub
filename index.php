<?php
include('config.php');

// Ensure only logged-in users can access this page
checkLoggedIn();

$username = $_SESSION['username'];
$role = $_SESSION['role'];
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
<body class="user-dashboard">
<div class="container fade-in user-dashboard">
    <div class="header">
        <img src="banner.png" alt="College Logo" class="logo">
    </div>
    <h2 class="user-title">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <p>
        <a href="create_event.php" class="nav-link">Submit New Event |</a>
        <a href="logout.php" class="nav-link-admin">Logout</a> 
        <?php if ($role === 'admin'): ?>
        <a href="admin_dashboard.php" class="nav-link">| Go to Admin Dashboard</a>
        <?php endif; ?>
    </p>

    <h3>Current Events</h3>
    <table>
        <thead>
            <tr>
                <th class="user-header">Title</th>
                <th class="user-header">Description</th>
                <th class="user-header">Start</th>
                <th class="user-header">End</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM events WHERE status IN ('approved', 'completed') AND deleted_at IS NULL ORDER BY event_start DESC";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td data-label='Title'>" . htmlspecialchars($row['title']) . "</td>
                        <td data-label='Description'>" . htmlspecialchars($row['description']) . "</td>
                        <td data-label='Start'>" . htmlspecialchars($row['event_start']) . "</td>
                        <td data-label='End'>" . htmlspecialchars($row['event_end']) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No current events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
