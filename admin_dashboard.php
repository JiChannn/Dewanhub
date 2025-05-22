<?php
include('config.php');

// Pastikan hanya admin boleh akses page ini
checkUserRole('admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - DewanHub</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style_mobile.css" media="only screen and (max-width: 600px)">
  <link rel="stylesheet" href="style_admin.css"> <!-- CSS khas untuk admin -->
</head>
<body>
<div class="container fade-in">
  <!-- Header dengan logo -->
  <div class="header">
    <img src="banner.png" alt="College Logo" class="logo">
  </div>

  <h2>Admin Dashboard - DewanHub</h2>
  <p>
    <!-- Link untuk logout dan pergi ke dashboard utama -->
    <a href="logout.php" class="logout-link">Logout</a> |
    <a href="index.php">Go to Main Dashboard</a>
  </p>

  <!-- Bahagian untuk event yang pending -->
  <h3>Pending Event Requests</h3>
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Date</th>
        <th>Submitted By</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Query untuk fetch event yang statusnya 'pending'
      $sqlPending = "SELECT events.*, users.username 
                     FROM events 
                     JOIN users ON events.user_id = users.id 
                     WHERE events.status = 'pending' AND events.deleted_at IS NULL 
                     ORDER BY events.event_date DESC";
      $resultPending = mysqli_query($conn, $sqlPending);

      // Check kalau ada event yang pending
      if ($resultPending && mysqli_num_rows($resultPending) > 0) {
          while ($row = mysqli_fetch_assoc($resultPending)) {
              // Paparkan setiap event dalam bentuk table row
              echo "<tr>
                      <td>" . htmlspecialchars($row['title']) . "</td>
                      <td>" . htmlspecialchars($row['description']) . "</td>
                      <td>" . htmlspecialchars($row['event_date']) . "</td>
                      <td>" . htmlspecialchars($row['username']) . "</td>
                      <td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>
                      <td>
                        <!-- Button untuk approve atau deny event -->
                        <a class='btn btn-success' href='approve_event.php?id={$row['id']}'>Approve</a>
                        <a class='btn btn-danger' href='deny_event.php?id={$row['id']}'>Deny</a>
                      </td>
                    </tr>";
          }
      } else {
          // Kalau tiada event yang pending
          echo "<tr><td colspan='6'>No pending events found.</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- Bahagian untuk event yang telah approved -->
  <h3>Approved Events</h3>
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Date</th>
        <th>Submitted By</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Query untuk fetch event yang statusnya 'approved' atau 'completed'
      $sqlApproved = "SELECT events.*, users.username 
                      FROM events 
                      JOIN users ON events.user_id = users.id 
                      WHERE events.status IN ('approved', 'completed') 
                      AND events.deleted_at IS NULL 
                      ORDER BY events.event_date DESC";
      $resultApproved = mysqli_query($conn, $sqlApproved);

      // Check kalau ada event yang approved
      if ($resultApproved && mysqli_num_rows($resultApproved) > 0) {
          while ($row = mysqli_fetch_assoc($resultApproved)) {
              // Paparkan setiap event dalam bentuk table row
              echo "<tr>
                      <td>" . htmlspecialchars($row['title']) . "</td>
                      <td>" . htmlspecialchars($row['description']) . "</td>
                      <td>" . htmlspecialchars($row['event_date']) . "</td>
                      <td>" . htmlspecialchars($row['username']) . "</td>
                      <td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>
                      <td>";
              if ($row['status'] === 'approved') {
                  // Button untuk mark event sebagai selesai
                  echo "<div class='btn-group'>
                          <a class='btn btn-warning' href='mark_complete.php?id={$row['id']}'>Mark as Done</a>
                          <a class='btn btn-danger' href='delete_event.php?id={$row['id']}' onclick=\"return confirm('Delete this event?')\">Delete</a>
                        </div>";
              }
              // Button untuk delete event
              echo "  </td>
                    </tr>";
          }
      } else {
          // Kalau tiada event yang approved
          echo "<tr><td colspan='6'>No approved events found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>