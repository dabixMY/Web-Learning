<?php
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $student_id = trim($_POST['student_id']);
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO students (student_id, name, email, password) VALUES (?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "isss", $student_id, $full_name, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        // c) Redirect to List of Courses page on success
        header("Location: courses.php");
        exit();
    } else {
        $error = "Registration failed. This Student ID or Email may already be registered.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Account - UTAR Study Plan Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <h1>Welcome to the UTAR Study Plan Management System</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="account.php">Register Account</a>
            <a href="courses.php">Select Courses</a>
        </nav>
    </header>

    <main>
        <h2>Create an Account</h2>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form id="registerForm" action="account.php" method="POST" novalidate>
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name">
            <span class="error" id="nameError"></span>

            <label for="email">Email Address:</label>
            <input type="text" id="email" name="email">
            <span class="error" id="emailError"></span>

            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id">
            <span class="error" id="idError"></span>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <span class="error" id="passwordError"></span>

            <button type="submit" class="btn-green">Register</button>
        </form>
    </main>

    <script src="validation.js"></script>
</body>

</html>