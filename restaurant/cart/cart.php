<?php
session_start();

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'cafe_data';
$port = 3308;
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $port);

if (!$conn) {
    die('Could not connect to the database: ' . mysqli_connect_error());
}

$isAdmin = isset($_SESSION['admin_id']);
$isUser = isset($_SESSION['user_id']);


// The login page (built separately) is expected to set $_SESSION['user_id']
// on successful login. Without it we can't tell whose cart this is.
if ($isAdmin) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Your Cart | Plate & Co. Cafe</title>
        <link rel="stylesheet" href="/restaurant/mystyle.css">
    </head>
    <body>

    <?php include('../includes/header.php'); ?>

    <main id="contentWrapper" class="content">
        <div class="cart-box">
            <h2>Customer Cart</h2>
            <p>You're signed in as an administrator.</p>
            <p>Shopping and checkout features are available when using a customer account.</p>
            <a href="/restaurant/" class="menu-button">Back to Home</a>
        </div>
    </main>

    <?php include('../includes/footer.php'); ?>

    </body>
    </html>
    <?php
    mysqli_close($conn);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Your Cart</title>
        <link rel="stylesheet" href="/restaurant/mystyle.css">
    </head>

    <body>

        <?php include('../includes/header.php'); ?><br>

        <div id="contentWrapper" class="content">
            <div class="cart-box">
                <h2>Your Cart</h2>
                <p>Please log in to view your cart.</p>
                <a href="../user/signin.php" class="menu-button">Log In</a>
            </div>
        </div>

        <?php include('../includes/footer.php'); ?>

    </body>

    </html>
    <?php
    mysqli_close($conn);
    exit;
}


$userId = (int) $_SESSION['user_id'];

// Handle add / update / remove / clear actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'add') {
        $dishId = (int) ($_POST['dish_id'] ?? 0);
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
        if ($quantity < 1) {
            $quantity = 1;
        }

        if ($dishId > 0) {
            $checkSql = "SELECT cart_id, quantity FROM cart WHERE user_id = $userId AND dish_id = $dishId";
            $checkResult = mysqli_query($conn, $checkSql);
            $existing = mysqli_fetch_assoc($checkResult);

            if ($existing) {
                $newQuantity = $existing['quantity'] + $quantity;
                mysqli_query($conn, "UPDATE cart SET quantity = $newQuantity WHERE cart_id = " . $existing['cart_id']);
            } else {
                mysqli_query($conn, "INSERT INTO cart (user_id, dish_id, quantity) VALUES ($userId, $dishId, $quantity)");
            }
        }
		
		header('Location: ../menu/menu.php');
		exit;
		
    } elseif ($action == 'update') {
        $cartId = (int) ($_POST['cart_id'] ?? 0);
        $rawQuantity = trim($_POST['quantity'] ?? '');

        // Only accept whole numbers from 1-20. Anything else (blank, letters,
        // decimals, negative numbers) is ignored - the cart is just left as is.
        if (ctype_digit($rawQuantity) && (int) $rawQuantity >= 1 && (int) $rawQuantity <= 20) {
            $quantity = (int) $rawQuantity;
            // WHERE also checks user_id so a user can only ever touch their own cart row
            mysqli_query($conn, "UPDATE cart SET quantity = $quantity WHERE cart_id = $cartId AND user_id = $userId");
        }
    } elseif ($action == 'remove') {
        $cartId = (int) ($_POST['cart_id'] ?? 0);
        mysqli_query($conn, "DELETE FROM cart WHERE cart_id = $cartId AND user_id = $userId");
    } elseif ($action == 'clear') {
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = $userId");
    }

    header('Location: ../cart/cart.php');
    exit;
}

// Load this user's cart items together with the dish info needed to display them
$sql = "SELECT cart.cart_id, cart.quantity, dishes.dish_id, dishes.name, dishes.price, dishes.image
        FROM cart
        JOIN dishes ON cart.dish_id = dishes.dish_id
        WHERE cart.user_id = $userId
        ORDER BY cart.cart_id ASC";
$result = mysqli_query($conn, $sql);

$cartItems = [];
$total = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $row['subtotal'] = $subtotal;
    $cartItems[] = $row;
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="/restaurant/mystyle.css">
</head>

<body>

    <?php include('../includes/header.php'); ?><br>

    <div id="contentWrapper" class="content">

        <div class="cart-box">

            <h2>Your Cart</h2>

            <?php if (empty($cartItems)) { ?>
                <p>Your cart is empty. <a href="../menu/menu.php">Browse the menu</a> to add something delicious.</p>
            <?php } else { ?>
                <table id="cartTable">
                    <tr>
                        <th>Dish</th>
                        <th>Price (RM)</th>
                        <th>Quantity</th>
                        <th>Subtotal (RM)</th>
                        <th>Remove</th>
                    </tr>
                    <?php foreach ($cartItems as $item) { ?>
                        <tr>
                            <td class="cart-dish-cell">
    <div class="dish-thumb">
        <?php if (!empty($item['image'])) { ?>
            <img 
                src="../images/<?php echo htmlspecialchars($item['image']); ?>" 
                alt="<?php echo htmlspecialchars($item['name']); ?>"
            >
        <?php } else { ?>
            <?php echo htmlspecialchars(strtoupper(substr($item['name'], 0, 1))); ?>
        <?php } ?>
    </div>

    <?php echo htmlspecialchars($item['name']); ?>
</td>
                            <td><?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form action="cart.php" method="post" class="qty-form">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                    <input type="text" name="quantity" placeholder="<?php echo $item['quantity']; ?>"
										inputmode="numeric" maxlength="2" class="qty-input">
                                    <button type="submit" class="small-btn">Update</button>
                                </form>
                            </td>
                            <td><?php echo number_format($item['subtotal'], 2); ?></td>
                            <td>
                                <form action="cart.php" method="post" class="qty-form">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                    <button type="submit" class="small-btn remove-btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr class="cart-total-row">
                        <td colspan="3">Total</td>
                        <td colspan="2">RM <?php echo number_format($total, 2); ?></td>
                    </tr>
                </table>

                <div class="cart-actions">
                    <form action="cart.php" method="post">
                        <input type="hidden" name="action" value="clear">
                        <button type="submit" class="small-btn remove-btn">Clear Cart</button>
                    </form>
                    <a href="checkout.php" class="menu-button">Proceed to Checkout</a>
                </div>
            <?php } ?>

        </div>

    </div>

    <?php include('../includes/footer.php'); ?>

</body>

</html>