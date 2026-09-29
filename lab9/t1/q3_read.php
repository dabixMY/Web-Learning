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
        // Check whether the CSV file exists before trying to read it
        $file = "users.csv";
        // Check whether the file exists before reading it.
        if (file_exists($file)) {

            // Open the CSV file for reading
            $handle = fopen($file, "r");

            // Read each row from the CSV file and display it in a table row
            while (($data = fgetcsv($handle)) !== false) {
                echo "<tr>";
                echo "<td>" . $data[0] . "</td>";
                echo "<td>" . $data[1] . "</td>";
                echo "<td>" . $data[2] . "</td>";
                echo "</tr>";
            }

            // Close the file after processing
            fclose($handle);
        }
        ?>

    </table>

</body>

</html>