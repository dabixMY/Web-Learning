<?php
require_once __DIR__ . '/../includes/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$recordId = $isAdmin ? ($_SESSION['admin_id'] ?? null) : ($_SESSION['user_id'] ?? null);

if ($recordId === null) {
    header('Location: /restaurant/user/signin.php');
    exit;
}

$message = '';
$messageType = '';

try {
    $table = $isAdmin ? 'admin' : 'users';
    $idColumn = $isAdmin ? 'adm_id' : 'user_id';
    $columns = $isAdmin
        ? 'adm_username AS username, adm_email AS email, adm_phone AS phone, adm_password AS password_hash'
        : 'username, email, phone, password AS password_hash';
    $statement = database()->prepare("SELECT {$columns} FROM {$table} WHERE {$idColumn} = :id LIMIT 1");
    $statement->execute(['id' => $recordId]);
    $profile = $statement->fetch();

    if (!$profile) {
        session_destroy();
        header('Location: /restaurant/user/signin.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';

        if ($username === '' || $email === '' || $phone === '') {
            $message = 'Username, email, and phone cannot be empty.';
            $messageType = 'error';
        } elseif ($oldPassword === '') {
            $message = 'Please enter your old password to save your profile.';
            $messageType = 'error';
        } elseif (strlen($username) > 50 || strlen($email) > 100 || strlen($phone) > 20) {
            $message = 'One or more fields are too long.';
            $messageType = 'error';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Please enter a valid email address.';
            $messageType = 'error';
        } elseif (!preg_match('/^\d{10,15}$/', $phone)) {
            $message = 'Phone number must contain 10 to 15 digits.';
            $messageType = 'error';
        } elseif (!password_verify($oldPassword, $profile['password_hash'])) {
            $message = 'The old password is incorrect.';
            $messageType = 'error';
        } elseif ($newPassword !== '' && strlen($newPassword) < 8) {
            $message = 'New password must be at least 8 characters.';
            $messageType = 'error';
        } else {
            $fields = $isAdmin
                ? 'adm_username = :username, adm_email = :email, adm_phone = :phone'
                : 'username = :username, email = :email, phone = :phone';
            $parameters = ['username' => $username, 'email' => $email, 'phone' => $phone, 'id' => $recordId];

            if ($newPassword !== '') {
                $fields .= $isAdmin ? ', adm_password = :password' : ', password = :password';
                $parameters['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            $update = database()->prepare("UPDATE {$table} SET {$fields} WHERE {$idColumn} = :id");
            $update->execute($parameters);
            $_SESSION['username'] = $username;
            $profile = ['username' => $username, 'email' => $email, 'phone' => $phone];
            $message = 'Profile updated successfully.';
            $messageType = 'success';
        }
    }
} catch (PDOException $exception) {
    $message = $exception->getCode() === '23000'
        ? 'That username or email address is already in use.'
        : 'Unable to load or update your profile.';
    $messageType = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        My Account<?= $isAdmin ? ' (Admin)' : '' ?> | Plate &amp; Co. Cafe
    </title>

    <link rel="stylesheet" href="/restaurant/mystyle.css">
</head>

<body class="profile-page">

<?php include __DIR__ . '/../includes/header.php'; ?>


<main class="profile-main">

    <!-- Profile Header -->

    <section class="profile-header">

        <p class="section-label">
            PLATE &amp; CO. CAFE
        </p>

        <div class="profile-avatar">
            <?= strtoupper(substr($profile['username'], 0, 1)); ?>
        </div>

        <h1 id="profile-title">
            My Account
        </h1>

        <p>
            Welcome back,
            <strong><?= escaped($profile['username']) ?></strong>
        </p>

        <?php if ($isAdmin): ?>

            <span class="profile-role">
                ADMIN
            </span>

        <?php endif; ?>

    </section>


    <!-- Profile Content -->

    <section class="profile-content">

        <?php if ($message !== ''): ?>

            <p class="form-message <?= escaped($messageType) ?>">
                <?= escaped($message) ?>
            </p>

        <?php endif; ?>


        <form
            action="/restaurant/user/profile.php"
            method="post"
            class="profile-form"
        >


            <!-- Profile Information -->

            <div class="profile-section">

                <div class="profile-section-heading">

                    <p class="section-label">
                        YOUR DETAILS
                    </p>

                    <h2>
                        Profile Information
                    </h2>

                    <p>
                        Update your personal information below.
                    </p>

                </div>


                <div class="profile-fields">

                    <div class="profile-field">

                        <label for="username">
                            Username
                        </label>

                        <input
                            id="username"
                            name="username"
                            type="text"
                            value="<?= escaped($profile['username']) ?>"
                            required
                        >

                    </div>


                    <div class="profile-field">

                        <label for="email">
                            Email
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="<?= escaped($profile['email']) ?>"
                            required
                        >

                    </div>


                    <div class="profile-field">

                        <label for="phone">
                            Phone Number
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            inputmode="numeric"
                            value="<?= escaped($profile['phone'] ?? '') ?>"
                            required
                        >

                    </div>

                </div>

            </div>


            <!-- Password -->

            <div class="profile-section">

                <div class="profile-section-heading">

                    <p class="section-label">
                        SECURITY
                    </p>

                    <h2>
                        Password
                    </h2>

                    <p>
                        Enter your current password before saving changes.
                    </p>

                </div>


                <div class="profile-fields">

                    <div class="profile-field">

                        <label for="old-password">
                            Current Password
                        </label>

                        <input
                            id="old-password"
                            name="old_password"
                            type="password"
                            autocomplete="current-password"
                            required
                        >

                    </div>


                    <div class="profile-field">

                        <label for="new-password">
                            New Password
                        </label>

                        <input
                            id="new-password"
                            name="new_password"
                            type="password"
                            autocomplete="new-password"
                            minlength="8"
                            placeholder="Leave blank to keep current password"
                        >

                    </div>

                </div>

            </div>


            <!-- Actions -->

            <div class="profile-actions">

                <button type="submit">
                    Save Changes
                </button>

                <a
                    class="profile-logout"
                    href="/restaurant/user/logout.php"
                >
                    Log Out
                </a>

            </div>


        </form>

    </section>

</main>


<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>