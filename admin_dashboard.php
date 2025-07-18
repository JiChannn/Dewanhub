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
  <link rel="stylesheet" href="style_admin.css">
</head>
<body>
<div class="container fade-in">
  <!-- Header dengan logo -->
  <div class="header">
    <img src="banner.png" alt="College Logo" class="logo">
  </div>

  <h2>Admin Dashboard - DewanHub</h2>
  
  <div class="nav-filter-row">
    <a href="logout.php" class="logout-link">Logout</a> |
    <a href="index.php" class="nav-link">Go to Main Dashboard</a>
    <form method="get" class="filter-form-inline">
        <label for="month" style="font-weight:bold;font-size:0.96em;margin:0 2px 0 10px;">Filter:</label>
        <input type="month" id="month" name="month" value="<?php echo isset($_GET['month']) ? htmlspecialchars($_GET['month']) : ''; ?>">
        <button type="submit" class="btn-link">Go</button>
        <a href="admin_dashboard.php" class="btn-link-admin">Reset</a>
    </form>
  </div>

  <h3 style="margin-top: 1.2em;">Event Details</h3>
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Start</th>
        <th>End</th>
        <th>Submitted By</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Query untuk fetch event yang statusnya 'approved' atau 'completed'
      $where = "WHERE events.status IN ('approved', 'completed') AND events.deleted_at IS NULL";
      $params = [];

      if (isset($_GET['month']) && $_GET['month'] !== "") {
          $month = $_GET['month']; // format: YYYY-MM
          $where .= " AND DATE_FORMAT(events.event_start, '%Y-%m') = '" . mysqli_real_escape_string($conn, $month) . "'";
      }

      $sqlApproved = "SELECT events.*, users.username 
                      FROM events 
                      JOIN users ON events.user_id = users.id 
                      $where
                      ORDER BY events.event_start DESC";
      $resultApproved = mysqli_query($conn, $sqlApproved);
      ?>
    </tbody>
    <?php
if ($resultApproved && mysqli_num_rows($resultApproved) > 0) {
    while ($row = mysqli_fetch_assoc($resultApproved)) {
        echo "<tr>
                <td data-label='Title'>" . htmlspecialchars($row['title']) . "</td>
                <td data-label='Description'>" . htmlspecialchars($row['description']) . "</td>
                <td data-label='Start'>" . htmlspecialchars($row['event_start']) . "</td>
                <td data-label='End'>" . htmlspecialchars($row['event_end']) . "</td>
                <td data-label='Submitted By'>" . htmlspecialchars($row['username']) . "</td>
                <td data-label='Action'>
                  <div class='action-link-group'>
                      <a class='action-link delete' href='delete_event.php?id=" . $row['id'] . "' onclick=\"return confirm('Delete this event?')\">Delete</a>
                      <a class='action-link print' href='print_event.php?id=" . $row['id'] . "' target='_blank'>Print</a>
                      <a class='action-link pdf' href='pdf_event.php?id=" . $row['id'] . "'>PDF</a>
                  </div>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6' style='text-align:center;'>There is no booking for this month</td></tr>";
}
?>
  </table>
</div>
</body>
</html>