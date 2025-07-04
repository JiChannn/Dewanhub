<?php
include('config.php');

$error = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username is already taken
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error = "Username already taken.";
    } else {
        // Insert new user; role defaults to 'user'
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Signup failed. Please try again.";
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up - DewanHub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_mobile.css" media="only screen and (max-width: 600px)">

</head>
<body>


    <div class="container fade-in">
        <div class="header">
            <img src="banner.png" alt="College Logo" class="logo">
        </div>
        <h2>Create a DewanHub Account</h2>
        <?php if (!empty($error)) echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; ?>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        
            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
 
</body>
</html>
