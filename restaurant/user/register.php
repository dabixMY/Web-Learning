<?php
require_once __DIR__ . '/../includes/database.php';

$message = '';
$messageType = '';
$username = '';
$email = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($username === '' || $password === '' || $email === '' || $phone === '') {
        $message = 'Please complete every field.';
        $messageType = 'error';
    } elseif (strlen($username) > 50 || strlen($email) > 100 || strlen($phone) > 20) {
        $message = 'One or more fields are too long.';
        $messageType = 'error';
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $message = 'Please enter a valid email address.';
        $messageType = 'error';
    } elseif (!preg_match('/^\d{10,15}$/', $phone)) {
        $message = 'Phone number must contain 10 to 15 digits.';
        $messageType = 'error';
    } elseif (strlen($password) < 8) {
        $message = 'Password must be at least 8 characters.';
        $messageType = 'error';
    } else {
        try {
            $statement = database()->prepare(
                'INSERT INTO users (username, email, password, phone) VALUES (:username, :email, :password, :phone)'
            );
            $statement->execute([
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'phone' => $phone,
            ]);
            header('Location: /restaurant/user/signin.php?registered=1');
            exit;
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                $message = 'That username or email address is already registered.';
            } else {
                $message = 'Unable to save your account. Please make sure cafe_data has been imported.';
            }
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Plate & Co. Cafe</title>
    <link rel="stylesheet" href="/restaurant/mystyle.css">
</head>
<body class="register-page">

<?php include('../includes/header.php'); ?>

<main class="register-main">

    <div class="register-container">

        <!-- Left Image -->

        <div class="register-image">

            <img
                src="/restaurant/signinbanner.jpg"
                alt="Plate & Co. Cafe"
            >

        </div>


        <!-- Right Form -->

        <section class="register-card" aria-labelledby="register-title">

            <p class="section-label">
                PLATE & CO. CAFE
            </p>

            <h1 id="register-title">
                Register
            </h1>

            <p class="sign-in-subtitle">
                Create your Plate &amp; Co. Cafe account.
            </p>

            <?php if ($message !== ''): ?>
                <p class="form-message <?= escaped($messageType) ?>">
                    <?= escaped($message) ?>
                </p>
            <?php endif; ?>

            <form action="/restaurant/user/register.php" method="post">

                <label for="username">
                    Username
                </label>

                <input
                    id="username"
                    name="username"
                    type="text"
                    autocomplete="username"
                    value="<?= escaped($username) ?>"
                    required
                >

                <label for="password">
                    Password
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    required
                >

                <label for="email">
                    Email
                </label>

                <input
                    id="email"
                    name="email"
                    type="text"
                    inputmode="email"
                    autocomplete="email"
                    value="<?= escaped($email) ?>"
                    required
                >

                <label for="phone">
                    Phone Number
                </label>

                <input
                    id="phone"
                    name="phone"
                    type="tel"
                    inputmode="numeric"
                    autocomplete="tel"
                    value="<?= escaped($phone) ?>"
                    required
                >

                <small class="field-help">
                    E.g. 0123456789 (10–15 digits)
                </small>

                <button type="submit">
                    Create Account
                </button>

            </form>

            <p class="account-prompt">
                Already have an account?
                <a href="/restaurant/user/signin.php">
                    Sign In
                </a>
            </p>

        </section>

    </div>

</main>

<?php include('../includes/footer.php'); ?>

<script>
const registerForm = document.querySelector('.sign-in-card form');
const registerEmail = document.getElementById('email');
const registerPhone = document.getElementById('phone');
const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phonePattern = /^\d{10,15}$/;

function validateEmail() {
    registerEmail.setCustomValidity(
        registerEmail.value && !emailPattern.test(registerEmail.value)
            ? 'Please enter a valid email address.'
            : ''
    );
}

function validatePhone() {
    registerPhone.setCustomValidity(
        registerPhone.value && !phonePattern.test(registerPhone.value)
            ? 'Please enter a phone number with 10 to 15 digits.'
            : ''
    );
}

registerEmail.addEventListener('input', () => registerEmail.setCustomValidity(''));
registerPhone.addEventListener('input', () => registerPhone.setCustomValidity(''));
registerForm.addEventListener('submit', (event) => {
    validateEmail();
    validatePhone();

    if (!registerForm.checkValidity()) {
        event.preventDefault();
        registerForm.reportValidity();
    }
});
</script>

</body>
</html>
