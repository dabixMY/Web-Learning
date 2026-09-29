<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); //redirect to the login
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Account</title>
    <link rel="stylesheet" href="form.css">
</head>

<body>

    <h1>Welcome,
        <?php echo $_SESSION['email']; ?>!
    </h1>

    <a href="logout.php">Logout</a>

</body>

</html>