<!DOCTYPE HTML>
<html>

<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="mystyle5.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <?php include('includes/navigation.php'); ?>
    <?php
    // contact/index.php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Initialize an array to hold error messages
        $errors = [];
        // Initialize variables
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $message = $_POST['message'] ?? '';
        $salutation = $_POST['salutation'] ?? '';
        $enquiry = $_POST['enquiry'] ?? [];

        // Perform validation
        if (empty($salutation)) {
            $errors['salutation'] = 'Salutation is required';
        }

        if (empty($name)) {
            $errors['name'] = 'Name is required';
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            // check if name only contains letters and whitespace
            $errors['name'] = 'Only alphabets and white space are allowed';
        }

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // FILTER_VALIDATE_EMAIL INT URL and IP
            $errors['email'] = 'A valid email is required';
        }

        $phone = str_replace([' ', '-', '(', ')'], '', $phone); // Strip common formatting characters
        if (empty($phone)) {
            $errors['phone'] = 'Phone number is required.';
        } elseif (!ctype_digit($phone)) {
            $errors['phone'] = 'Phone number must be numeric.';
        } elseif (strlen($phone) < 10 || strlen($phone) > 15) {
            $errors['phone'] = 'Phone number must be between 10 and 15 digits.';
        }

        if (empty($enquiry)) {
            $errors['enquiry'] = 'At least one type of enquiry is required';
        }

        if (empty($message)) {
            $errors['message'] = 'Subject is required';
        }

        // Check if there are any errors
        if (empty($errors)) {
            // Process the input (send mail, etc.)
            // For example:
            echo "<div id='contentWrapper' class='content'>";
            echo "<h2>Submission Details</h2>";
            echo "Salutation: " . htmlspecialchars($salutation) . "<br>";
            echo "Name: " . htmlspecialchars($name) . "<br>";
            echo "Email: " . htmlspecialchars($email) . "<br>";
            echo "Phone: " . htmlspecialchars($phone) . "<br>";
            echo "Enquiry: " . implode(', ', array_map('htmlspecialchars', $enquiry)) . "<br>";
            echo "Message: " . htmlspecialchars($message) . "<br><br>";

            // Redirect or display a success message
            echo 'Thank you for contacting us! We will get back to you shortly.';
            echo "</div>";
        } else {
            // Redisplay the form, with error messages
            include('_form.php');
        }
    } else {
        // Display the form for the first time
        $name = $email = $phone = $message = $salutation = '';
        $enquiry = [];
        $errors = [];
        include('_form.php');
    }
    ?>
    <?php include('includes/footer.php'); ?>
</body>

</html>