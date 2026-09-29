<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Read posted form values
    $username = $_POST["username"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];

    // Open CSV file in append mode
    $handle = fopen("users.csv", "a");

    // Save new user data as a CSV row
    fputcsv($handle, [$username, $email, $gender]);

    // Close file
    fclose($handle);

    // Confirm success
    echo "User record has been added.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add User</title>
</head>

<body>

    <h2>Add User</h2>

    <form method="post">
        Username:<br>
        <input type="text" name="username"><br><br>

        Email:<br>
        <input type="text" name="email"><br><br>

        Gender:<br>
        <select name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <br><br>

        <input type="submit" value="Add User">
    </form>

</body>

</html>