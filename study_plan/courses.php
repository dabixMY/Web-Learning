<?php
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $selected_courses = isset($_POST['courses']) ? $_POST['courses'] : [];

    // c) Check whether the student ID exists
    $check = mysqli_prepare($conn, "SELECT student_id FROM students WHERE student_id = ?");
    mysqli_stmt_bind_param($check, "i", $student_id);
    mysqli_stmt_execute($check);
    $checkResult = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($checkResult) == 0) {
        $error = "Student ID does not exist. Please <a href='account.php'>register</a>.";
    } else {
        // b) Save selected courses into student_courses
        foreach ($selected_courses as $course_id) {
            $course_id = intval($course_id);
            $insert = mysqli_prepare(
                $conn,
                "INSERT IGNORE INTO student_courses (student_id, course_id) VALUES (?, ?)"
            );
            mysqli_stmt_bind_param($insert, "ii", $student_id, $course_id);
            mysqli_stmt_execute($insert);
        }

        // d) Redirect to profile.php with student_id as query parameter
        header("Location: profile.php?student_id=" . urlencode($student_id));
        exit();
    }
}

// a) Retrieve course data from the database
$courses_result = mysqli_query($conn, "SELECT * FROM courses");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Select Courses - UTAR Study Plan Management System</title>
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
        <h2>Select Courses</h2>

        <?php if ($error): ?>
            <p class="error">Error: <?php echo $error; ?></p>
        <?php endif; ?>

        <form action="courses.php" method="POST">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required>

            <h3>Available Courses</h3>

            <?php while ($course = mysqli_fetch_assoc($courses_result)): ?>
                <div class="course-item">
                    <label class="course-label">
                        <input type="checkbox" name="courses[]" value="<?php echo $course['course_id']; ?>">
                        <strong><?php echo htmlspecialchars($course['course_code']); ?> -
                            <?php echo htmlspecialchars($course['course_name']); ?></strong>
                    </label>
                    <p class="course-desc"><?php echo nl2br(htmlspecialchars(trim($course['course_description']))); ?></p>
                </div>
            <?php endwhile; ?>

            <button type="submit" class="btn-green">Save Selected Courses</button>
        </form>
    </main>

</body>

</html>