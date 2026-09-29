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


if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/signin.php');
    exit;
}


$userId = (int) $_SESSION['user_id'];
$orderPlaced = false;
$orderId = 0;

// Service tax rate (Malaysian SST for F&B is commonly 6%).
$serviceTaxRate = 0.06;

// Place the order (only runs when the "Confirm Order" button is submitted)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $sql = "SELECT cart.dish_id, cart.quantity, dishes.price
            FROM cart
            JOIN dishes ON cart.dish_id = dishes.dish_id
            WHERE cart.user_id = $userId";
    $result = mysqli_query($conn, $sql);

    $orderSubtotal = 0;
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orderSubtotal += $row['price'] * $row['quantity'];
        $items[] = $row;
    }

    if (!empty($items)) {
        // total_amount stored in the DB includes service tax, since that's
        // the actual amount the customer is charged.
        $orderTax = $orderSubtotal * $serviceTaxRate;
        $orderGrandTotal = $orderSubtotal + $orderTax;

        mysqli_query($conn, "INSERT INTO orders (user_id, total_amount, status) VALUES ($userId, $orderGrandTotal, 'Pending')");
        $orderId = mysqli_insert_id($conn);

        foreach ($items as $item) {
            $dishId = (int) $item['dish_id'];
            $quantity = (int) $item['quantity'];
            mysqli_query($conn, "INSERT INTO order_details (order_id, dish_id, quantity) VALUES ($orderId, $dishId, $quantity)");
        }

        // Order has been recorded, so the cart is now empty
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = $userId");

        $orderPlaced = true;
    }
}

// Build the bill to show on screen. After an order is placed, show the
// items that were just ordered instead of the (now empty) cart.
$billItems = [];
$billSubtotal = 0;

if ($orderPlaced) {
    $sql = "SELECT order_details.quantity, dishes.name, dishes.price
            FROM order_details
            JOIN dishes ON order_details.dish_id = dishes.dish_id
            WHERE order_details.order_id = $orderId";
} else {
    $sql = "SELECT cart.quantity, dishes.name, dishes.price
            FROM cart
            JOIN dishes ON cart.dish_id = dishes.dish_id
            WHERE cart.user_id = $userId";
}

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['price'] * $row['quantity'];
    $billSubtotal += $subtotal;
    $row['subtotal'] = $subtotal;
    $billItems[] = $row;
}

mysqli_close($conn);

// Nothing to check out and no order was just placed - send them back to the cart
if (empty($billItems) && !$orderPlaced) {
    header('Location: cart.php');
    exit;
}

$billServiceTax = $billSubtotal * $serviceTaxRate;
$billGrandTotal = $billSubtotal + $billServiceTax;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="/restaurant/mystyle.css">
</head>

<body>

    <?php include('../includes/header.php'); ?><br>

    <div id="contentWrapper" class="content">

        <div class="checkout-box">

            <h2>Checkout</h2>

            <?php if ($orderPlaced) { ?>
                <p class="checkout-success">Order #<strong><?php echo $orderId; ?></strong> placed successfully. Thank you!</p>
            <?php } ?>

            <div class="receipt">

                <div class="receipt-header">
                    <h3>PLATE &amp; CO. CAFE</h3>
                    <p>125 Cozy Street </p>
					<p>Kuala Lumpur, Malaysia</p>
                    <p>Tel: 010-438 8315</p>
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-meta">
                    <div class="receipt-line">
                        <span>Order #</span>
                        <span><?php echo $orderPlaced ? $orderId : 'PREVIEW'; ?></span>
                    </div>
                    <div class="receipt-line">
                        <span>Date</span>
                        <span><?php echo date('d/m/Y H:i'); ?></span>
                    </div>
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-items">
                    <?php foreach ($billItems as $item) { ?>
                        <div class="receipt-line">
                            <span><?php echo $item['quantity']; ?> x <?php echo htmlspecialchars($item['name']); ?></span>
                            <span><?php echo number_format($item['subtotal'], 2); ?></span>
                        </div>
                    <?php } ?>
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-totals">
                    <div class="receipt-line">
                        <span>Subtotal</span>
                        <span><?php echo number_format($billSubtotal, 2); ?></span>
                    </div>
                    <div class="receipt-line">
                        <span>Service Tax (<?php echo $serviceTaxRate * 100; ?>%)</span>
                        <span><?php echo number_format($billServiceTax, 2); ?></span>
                    </div>
                    <div class="receipt-line receipt-grand-total">
                        <span>TOTAL</span>
                        <span>RM <?php echo number_format($billGrandTotal, 2); ?></span>
                    </div>
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-footer">
                    <p>Thank you, come again!</p>
                </div>

                <div class="receipt-zigzag"></div>

            </div>

            <?php if ($orderPlaced) { ?>
                <div class="checkout-actions">
                    <a href="../menu/menu.php" class="menu-button">Back to Menu</a>
                </div>
            <?php } else { ?>
                <div class="checkout-actions">
                    <form action="checkout.php" method="post">
                        <button type="submit" name="place_order" class="menu-button">Confirm Order</button>
                    </form>
                </div>
                <a href="cart.php" class="back-link">&larr; Back to cart</a>
            <?php } ?>

        </div>

    </div>

    <?php include('../includes/footer.php'); ?>

</body>

</html>