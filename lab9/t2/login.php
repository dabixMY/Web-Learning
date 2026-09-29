<?php
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    header('Location: account.php');
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'lab9', 3308);

    // Check if the connection was successful
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Prepare the SQL query
    $query = "SELECT * FROM users WHERE email='$email' AND password='" . md5($password) . "'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if there was a match
    if (mysqli_num_rows($result) == 1) {
        // Login successful, store the email in the session
        $_SESSION['email'] = $email;

        // Redirect to account.php
        header('Location: account.php');
        exit();
    } else {
        // Login unsuccessful, display an error message
        $error = 'Invalid email or password.';
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="form.css">
</head>

<body>

    <h1>Login</h1>

    <?php
    if (isset($error)) {
        echo '<p>' . $error . '</p>';
    }
    ?>

    <form method="POST">
        Email:<br>
        <input type="email" name="email" required><br><br>

        Password:<br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <a href="create.php">Don't have an account? Create one here</a>

</body>

</html>