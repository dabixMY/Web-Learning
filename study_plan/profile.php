<?php
include 'db_connect.php';

$student_id = isset($_GET['student_id']) ? trim($_GET['student_id']) : "";
$student = null;
$notFound = false;

if ($student_id !== "") {
    $stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE student_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);

    if (!$student) {
        $notFound = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile - UTAR Study Plan Management System</title>
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
        <?php if ($student_id === ""): ?>
            <!-- Bonus 1: Student ID not provided as query parameter -->
            <p class="notice">Please enter your Student ID to view your profile.</p>
            <h2>Enter Your Student ID</h2>
            <form action="profile.php" method="GET">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id">
                <button type="submit" class="btn-green">View Profile</button>
            </form>

        <?php elseif ($notFound): ?>
            <!-- Bonus 3: Invalid student ID -->
            <p class="notice error">Student ID not found. Please <a href="account.php">register an account</a>.</p>
            <h2>Enter Your Student ID</h2>
            <form action="profile.php" method="GET">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id">
                <button type="submit" class="btn-green">View Profile</button>
            </form>

        <?php else: ?>
            <!-- Bonus 2 / Task 5: Valid student ID -->
            <h2>My Profile</h2>
            <p><strong>Name:</strong>
                <?php echo htmlspecialchars($student['name']); ?>
            </p>
            <p><strong>Email:</strong>
                <?php echo htmlspecialchars($student['email']); ?>
            </p>
            <p><strong>Student ID:</strong>
                <?php echo htmlspecialchars($student['student_id']); ?>
            </p>

            <?php
            $courseStmt = mysqli_prepare(
                $conn,
                "SELECT c.course_code, c.course_name, c.course_description
                 FROM student_courses sc
                 JOIN courses c ON sc.course_id = c.course_id
                 WHERE sc.student_id = ?"
            );
            mysqli_stmt_bind_param($courseStmt, "i", $student_id);
            mysqli_stmt_execute($courseStmt);
            $courseResult = mysqli_stmt_get_result($courseStmt);
            ?>

            <h3>Selected Courses</h3>
            <?php if (mysqli_num_rows($courseResult) == 0): ?>
                <p>No course selected</p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Course Description</th>
                    </tr>
                    <?php while ($c = mysqli_fetch_assoc($courseResult)): ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($c['course_code']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($c['course_name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars(trim($c['course_description'])); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php endif; ?>
        <?php endif; ?>
    </main>

</body>

</html>