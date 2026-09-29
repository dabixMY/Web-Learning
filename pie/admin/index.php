<!DOCTYPE html>
<html>

<head>
    <title>Control panel</title>
    <link rel="stylesheet" href="../style/mystyle.css">
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <?php include('../includes/navigation.php'); ?>

    <div id="contentWrapper" class="content">

        <ul>
            <li><a href="./create.php">Create New Post</a></li>
        </ul>

        <h2>Retrieve All Announcements</h2>

        <?php
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'uecs2094_pie';
        $port = 3308;
        $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $port);

        if (!$conn) {
            die('Could not connect to the database: ' . mysqli_connect_error());
        } else {
            $sql = "SELECT * FROM announcement ORDER BY posted DESC";
            $result = mysqli_query($conn, $sql);

            if (!$result || mysqli_num_rows($result) === 0) {
                echo '<p>No posts found.</p>';
            } else {
                echo "<table>";
                echo "<tr>";
                echo "<th>Subject</th><th>Message</th><th>Type</th><th>Posted</th><th colspan=2>Actions</th>";
                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['subject'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "<td>" . $row['posted'] . "</td>";
                    echo "<td><a href='update.php?id=" . $row['id'] . "'>Update</a></td>";
                    echo "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }

            mysqli_close($conn);
        }
        ?>

    </div>

    <?php include('../includes/footer.php'); ?>

</body>

</html>