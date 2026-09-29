<?php
// Check if the form was submitted using the POST method.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve user input from the form fields.
    $username = $_POST["username"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];

    // Combine the form data into a tab-separated string.
    $data = $username . "\t" . $email . "\t" . $gender . "\n";

    // Append the new user record to the users.txt file.
    file_put_contents("users.txt", $data, FILE_APPEND);

    // Display a confirmation message after saving the record.
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