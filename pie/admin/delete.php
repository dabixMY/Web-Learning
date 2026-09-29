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

        <h2>Delete Announcement</h2>

        <?php
        $id = $_GET['id'];

        if ($id <= 0) {
            echo '<p>Invalid post id.</p>';
        } else {
            $dbHost = 'localhost';
            $dbUser = 'root';
            $dbPass = '';
            $dbName = 'uecs2094_pie';
            $port = 3308;
            $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $port);

            if (!$conn) {
                die('Could not connect to the database: ' . mysqli_connect_error());
            } else {
                $sql = "DELETE FROM announcement WHERE id = $id";

                if (mysqli_query($conn, $sql)) {
                    echo '<p>Post deleted successfully.</p>';
                } else {
                    echo '<p>Post not found or could not be deleted.</p>';
                }

                mysqli_close($conn);
            }
        }
        ?>
        <p><a href='index.php'>Back to index</a></p>
    </div>

    <?php include('../includes/footer.php'); ?>

</body>

</html>