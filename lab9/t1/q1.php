<!DOCTYPE html>
<html>

<head>
    <title>Users</title>
</head>

<body>

    <h2>User List</h2>

    <table border="1" cellpadding="8">
        <!-- Table header for user records -->
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Gender</th>
        </tr>

        <?php
        // Check whether the txt file exists before trying to read it
        $file = "users.txt";
        // Check whether the file exists before reading it.
        if (file_exists($file)) {

            // Read all lines from the file into an array.
            $lines = file($file);

            // Loop through each line and display it as a table row.
            foreach ($lines as $line) {

                // Split each row by a tab character into username, email, and gender.
                $data = explode("\t", trim($line));

                echo "<tr>";
                echo "<td>" . $data[0] . "</td>";
                echo "<td>" . $data[1] . "</td>";
                echo "<td>" . $data[2] . "</td>";
                echo "</tr>";
            }
        }
        ?>

    </table>

</body>

</html>