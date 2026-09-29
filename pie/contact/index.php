<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../style/mystyle.css">
    <title>About PIEB</title>
    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <?php include('../includes/header.php'); ?>
    <?php include('../includes/navigation.php'); ?>
    <div id="contentWrapper" class="content">
        <form id="contactForm" action="post-message.php" method="post">
            Salutation:
            <select id="Sal" name="salutation" required>
                <option disabled selected value> -- Select a Salutation -- </option>
                <option value="mr">Mr</option>
                <option value="ms">Ms</option>
                <option value="mrs">Mrs</option>
                <option value="mdm">Mdm</option>
            </select>
            <div id="salutationError" class="error"></div>
            <br>

            Name: <input type="text" id="nam" name="name" required><br>
            <div id="nameError" class="error"></div>
            E-mail: <input type="text" id="email" name="email" required><br>
            <div id="emailError" class="error"></div>
            Phone Number: <input type="tel" id="phone" name="phone" required><br>
            <div id="phoneError" class="error"></div>

            Type of Enquiry:
            <input type="checkbox" name="enquiry" value="General Enquiry"> General Enquiry
            <input type="checkbox" name="enquiry" value="Complaints"> Complaints
            <input type="checkbox" name="enquiry" value="Suggestions"> Suggestions<br>
            <div id="enquiryError" class="error"></div>
            Subject:<br>
            <textarea id="message" name="message" rows="10" cols="30" required></textarea>
            <div id="messageError" class="error"></div>
            <br>
            <input type="button" value="Send" onclick="validateForm()">

        </form>
    </div>
    <?php include('../includes/footer.php'); ?>

    <script>
        function validateForm() {
            var isValid = true;
            var form = document.getElementById('contactForm');

            // Clear previous error messages
            document.querySelectorAll('#contactForm div').forEach(function (div) {
                div.textContent = '';
            });

            // Validate Salutation
            if (form['salutation'].value.trim() === '') {
                document.getElementById('salutationError').textContent = 'Please select your salutation.';
                isValid = false;
            }

            // Validate Name
            if (form['name'].value.trim() === '') {
                document.getElementById('nameError').textContent = 'Name is required.';
                isValid = false;
            }

            // Validate Email
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (form['email'].value.trim() === '') {
                document.getElementById('emailError').textContent = 'Email is required.';
                isValid = false;
            } else if (!emailPattern.test(form['email'].value.trim())) {
                document.getElementById('emailError').textContent = 'Email is invalid.';
                isValid = false;
            }

            // Validate Phone Number
            if (form['phone'].value.trim() === '') {
                document.getElementById('phoneError').textContent = 'Phone number is required.';
                isValid = false;
            } else if (!/^\d{10,15}$/.test(form['phone'].value)) {
                document.getElementById('phoneError').textContent = 'Enter a valid phone number.';
                isValid = false;
            }

            // Validate Enquiry Type,... convert the checkbox collection into an array
            if (![...form['enquiry']].some(checkbox => checkbox.checked)) {
                document.getElementById('enquiryError').textContent = 'Please select at least one type of enquiry.';
                isValid = false;
            }

            // Validate Message
            if (form['message'].value.trim() === '') {
                document.getElementById('messageError').textContent = 'Message is required.';
                isValid = false;
            }

            if (isValid == true) {
                form.submit();
            }
        }
    </script>
</body>

</html>