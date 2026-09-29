<?php
require_once __DIR__ . '/../includes/database.php';

$message = '';
$messageType = '';
$username = '';
$email = '';

if (isset($_GET['registered'])) {
    $message = 'Account created. Please sign in.';
    $messageType = 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $message = 'Please enter your username, email, and password.';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $messageType = 'error';
    } else {
        try {
            $adminStatement = database()->prepare(
                'SELECT adm_id, adm_username, adm_password FROM admin WHERE adm_username = :username AND adm_email = :email LIMIT 1'
            );
            $adminStatement->execute(['username' => $username, 'email' => $email]);
            $admin = $adminStatement->fetch();

            if ($admin && password_verify($password, $admin['adm_password'])) {
                session_start();
                session_regenerate_id(true);
                unset($_SESSION['user_id']);
                $_SESSION['admin_id'] = $admin['adm_id'];
                $_SESSION['username'] = $admin['adm_username'];
                $_SESSION['role'] = 'admin';
                header('Location: /restaurant/');
                exit;
            }

            $statement = database()->prepare(
                'SELECT user_id, username, password FROM users WHERE username = :username AND email = :email LIMIT 1'
            );
            $statement->execute(['username' => $username, 'email' => $email]);
            $user = $statement->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                session_regenerate_id(true);
                unset($_SESSION['admin_id'], $_SESSION['role']);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /restaurant/');
                exit;
            } else {
                $message = 'Incorrect username or password.';
                $messageType = 'error';
            }
        } catch (PDOException $exception) {
            $message = 'Invalid username, email, or password.';
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
    <title>Sign In | Plate & Co. Cafe</title>
    <link rel="stylesheet" href="/restaurant/mystyle.css">
</head>
<body class="sign-in-page">

<?php include('../includes/header.php'); ?>

<main class="sign-in-main">

    <div class="sign-in-container">

        <!-- Left Side Image -->

        <div class="sign-in-image">

            <img
                src="/restaurant/signinbanner.jpg"
                alt="Plate & Co. Cafe"
            >

        </div>


        <!-- Right Side Form -->

        <section class="sign-in-card">

            <p class="section-label">
                PLATE & CO. CAFE
            </p>

            <h1 id="sign-in-title">
                Sign In
            </h1>

            <p class="sign-in-subtitle">
                Welcome back to the cafe.
            </p>

            <?php if ($message !== ''): ?>
                <p class="form-message <?= escaped($messageType) ?>">
                    <?= escaped($message) ?>
                </p>
            <?php endif; ?>

            <form action="/restaurant/user/signin.php" method="post">

                <label for="username">Username</label>

                <input
                    id="username"
                    name="username"
                    type="text"
                    autocomplete="username"
                    value="<?= escaped($username) ?>"
                    required
                >

                <label for="email">Email</label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    value="<?= escaped($email) ?>"
                    required
                >

                <label for="password">Password</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                >

                <button type="submit">
                    Sign In
                </button>

            </form>

            <p class="account-prompt">
                Don't have an account?
                <a href="/restaurant/user/register.php">
                    Register here
                </a>
            </p>

        </section>

    </div>

</main>

<?php include('../includes/footer.php'); ?>

</body>
</html>
