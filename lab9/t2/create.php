<?php
// Process account creation only when the form is submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Connect to the lab9 database server.
    $conn = mysqli_connect('localhost', 'root', '', 'lab9', 3308);

    // Stop execution if the database connection fails.
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Escape submitted values before using them in SQL queries.
    // Characters encoded are NUL (ASCII 0), \n, \r, \, ', ", and CTRL+Z.
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check whether an account with this email already exists.
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $sql);

    // Reject the registration if the email is already registered.
    if (mysqli_num_rows($checkResult) > 0) {
        echo 'Email already exists. Please use a different email.';
    } else {
        // Hash the password before storing it in the database.
        $hashed_password = md5($password);

        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

        // Insert the new account and display the appropriate result.
        if (mysqli_query($conn, $sql)) {
            echo 'Account created successfully. ';
            echo '<a href="login.php">Login here</a>';
        } else {
            echo 'Error creating account: ' . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="form.css">
</head>

<body>

    <h1>Create Account</h1>

    <form method="POST">
        Email:<br>
        <input type="email" name="email" required><br><br>

        Password:<br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Create Account">
    </form>

    <br>

    <a href="login.php">Already have an account? Click here to login</a>

</body>

</html>