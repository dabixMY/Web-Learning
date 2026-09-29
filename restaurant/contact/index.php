<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'cafe_data';
$port = 3308;

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $port);

if (!$conn) {
    die('Could not connect to the database: ' . mysqli_connect_error());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $salutation = trim($_POST['salutation'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $enquiryType = trim($_POST['enquiry_type'] ?? '');
    $feedbackCategory = trim($_POST['feedback_category'] ?? '');
    $userMessage = trim($_POST['message'] ?? '');

    if (
        $salutation === '' ||
        $name === '' ||
        $email === '' ||
        $phone === '' ||
        $enquiryType === '' ||
        $userMessage === ''
    ) {
        $message = 'Please fill in all required fields.';
    } else {

        $sql = "INSERT INTO contact
                (salutation, name, email, phone, enquiry_type, feedback_category, message)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssssss",
            $salutation,
            $name,
            $email,
            $phone,
            $enquiryType,
            $feedbackCategory,
            $userMessage
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = 'Thank you! Your message has been submitted successfully.';
        } else {
            $message = 'Failed to submit your message.';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Plate &amp; Co. Cafe</title>
    <link rel="stylesheet" href="/restaurant/mystyle.css">
</head>
<body>

<?php include('../includes/header.php'); ?>

<main class="contact-main">
    <section class="contact-card" aria-labelledby="contact-title">
        <p class="contact-kicker">WE WOULD LOVE TO HEAR FROM YOU</p>
        <h2 id="contact-title">Contact Us</h2>
        <p class="contact-intro">Share a compliment, complaint, or suggestion with the Plate &amp; Co. Cafe team.</p>
		
<?php if ($message !== ''): ?>
    <p class="form-message"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

        <form class="contact-form" action="" method="post">
            <div class="form-grid">
                <div class="form-field">
                    <label for="salutation">Salutation</label>
                    <select id="salutation" name="salutation" required>
                        <option value="">Select a salutation</option>
                        <option>Mr.</option>
                        <option>Ms.</option>
                        <option>Mrs.</option>
                        <option>Mdm.</option>
                    </select>
                </div>

                <div class="form-field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="text" inputmode="email" autocomplete="email" required>
                </div>

                <div class="form-field">
                    <label for="phone">Phone Number</label>
                    <input id="phone" name="phone" type="tel" inputmode="numeric" autocomplete="tel" aria-describedby="phone-example" required>
                    <small id="phone-example" class="field-help">E.g. 0123456789 (10–15 digits)</small>
                </div>
            </div>

            <div class="form-field form-field-full">
                <label for="enquiry-type">Type of Enquiry</label>
                <select id="enquiry-type" name="enquiry_type" required>
                    <option value="">Select an enquiry type</option>
                    <option value="Praise">Praise</option>
                    <option value="Complaint">Complaint</option>
                    <option value="Suggestions">Suggestions</option>
                </select>
            </div>

            <div id="feedback-category-wrap" class="form-field form-field-full is-hidden">
                <label id="feedback-category-label" for="feedback-category">Type of Praise / Complaint</label>
                <select id="feedback-category" name="feedback_category">
                    <option value="">Select a category</option>
                    <option value="food">Food</option>
                    <option value="drinks">Drinks</option>
                    <option value="environment">Environment</option>
                    <option value="overall">Overall</option>
                </select>
            </div>

            <div class="form-field form-field-full">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="8" placeholder="Tell us more about your experience..." required></textarea>
            </div>

            <button class="contact-submit" type="submit">SEND MESSAGE</button>
        </form>
    </section>
</main>

<?php include('../includes/footer.php'); ?>

<script>
const enquiryType = document.getElementById('enquiry-type');
const categoryWrap = document.getElementById('feedback-category-wrap');
const categoryLabel = document.getElementById('feedback-category-label');
const category = document.getElementById('feedback-category');
const contactForm = document.querySelector('.contact-form');
const contactEmail = document.getElementById('email');
const contactPhone = document.getElementById('phone');
const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phonePattern = /^\d{10,15}$/;

function validateEmail() {
    contactEmail.setCustomValidity(
        contactEmail.value && !emailPattern.test(contactEmail.value)
            ? 'Please enter a valid email address.'
            : ''
    );
}

function validatePhone() {
    contactPhone.setCustomValidity(
        contactPhone.value && !phonePattern.test(contactPhone.value)
            ? 'Please enter a phone number with 10 to 15 digits.'
            : ''
    );
}

function updateFeedbackFields() {
    const type = enquiryType.value;
    categoryWrap.classList.toggle('is-hidden', type === '');
    category.required = type !== '';
    categoryLabel.textContent = type ? `Type of ${type}` : 'Type of Praise / Complaint';
}

enquiryType.addEventListener('change', updateFeedbackFields);
updateFeedbackFields();

contactEmail.addEventListener('input', () => contactEmail.setCustomValidity(''));
contactPhone.addEventListener('input', () => contactPhone.setCustomValidity(''));
contactForm.addEventListener('submit', (event) => {
    validateEmail();
    validatePhone();

    if (!contactForm.checkValidity()) {
        event.preventDefault();
        contactForm.reportValidity();
    }
});
</script>

</body>
</html>
