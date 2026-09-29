<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <h1>Delete User</h1>
    <form method="post" action="delete_user.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <input type="submit" name="submit" value="Delete User">
    </form>

    <?php
    function sanitize($data) {
        return htmlspecialchars(trim($data));
    }

    if (isset($_POST['submit'])) {
        $username = sanitize($_POST['username']);

        $file = fopen("users.txt", "r");
        if ($file === false) {
            die("Error opening the file.");
        }

        $updated_content = '';
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            $currentUsername = explode("\t", $line)[0];
            if ($currentUsername !== $username) {
                $updated_content .= $line . "\r\n";
            }
        }
        fclose($file);

        $file = fopen("users.txt", "w");
        if ($file === false) {
            die("Error opening the file.");
        }
        fwrite($file, $updated_content);
        fclose($file);

        header("Location: index.php");
        exit;
    }
    ?>
</body>
</html>
