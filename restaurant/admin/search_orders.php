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

$statusFilter = $_GET['status'] ?? 'All';
$search = trim($_GET['search'] ?? '');

$sql = "SELECT orders.*, users.username, users.phone FROM orders LEFT JOIN users ON orders.user_id = users.user_id";
$conditions = [];

if ($statusFilter !== 'All') {
    $escStatus = mysqli_real_escape_string($conn, $statusFilter);
    $conditions[] = "orders.status = '$escStatus'";
}

if ($search !== '') {
    $escSearch = mysqli_real_escape_string($conn, $search);
    $conditions[] = "(orders.order_id = '$escSearch' OR users.username LIKE '%$escSearch%' OR users.phone LIKE '%$escSearch%')";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY orders.order_date DESC";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo '<p>No orders found.</p>';
} else {
    ?>
    <div class="order-row-header">
        <span>Order ID</span>
        <span>Username</span>
        <span>Status</span>
        <span>Amount</span>
        <span>Date</span>
    </div>
    <?php
    while ($order = mysqli_fetch_assoc($result)) {
        $statusClass = 'status-' . strtolower($order['status']);
        $friendlyDate = date('d M Y, g:i A', strtotime($order['order_date']));
        $customerName = $order['username'] ?? 'Unknown';
        ?>
        <details>
            <summary>
                <div class="order-row">
                    <span>#<?php echo $order['order_id']; ?></span>
                    <span class="col-username"><?php echo $customerName; ?></span>
                    <span><span class="status-badge <?php echo $statusClass; ?>"><?php echo $order['status']; ?></span></span>
                    <span>RM <?php echo $order['total_amount']; ?></span>
                    <span><?php echo $friendlyDate; ?></span>
                </div>
            </summary>

            <p>Phone: <?php echo $order['phone'] ?? 'N/A'; ?></p>

            <form action="manage_orders.php?status=<?php echo urlencode($statusFilter); ?>" method="post">
                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                Status:
                <select name="status">
                    <option value="Pending" <?php echo $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending
                    </option>
                    <option value="Completed" <?php echo $order['status'] === 'Completed' ? 'selected' : ''; ?>>Completed
                    </option>
                    <option value="Cancelled" <?php echo $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled
                    </option>
                </select>
                <button type="submit" name="update_status">Update Status</button>
            </form>

            <?php
            $detailSql = "SELECT order_details.quantity, dishes.name, dishes.price FROM order_details INNER JOIN dishes ON order_details.dish_id = dishes.dish_id WHERE order_details.order_id = " . $order['order_id'];
            $detailResult = mysqli_query($conn, $detailSql);
            ?>

            <table class="order-items">
                <tr>
                    <th>Dish</th>
                    <th>Unit Price (RM)</th>
                    <th>Quantity</th>
                </tr>
                <?php
                $orderTotal = 0;

                if ($detailResult && mysqli_num_rows($detailResult) > 0) {
                    while ($detail = mysqli_fetch_assoc($detailResult)) {
                        $lineTotal = $detail['price'] * $detail['quantity'];
                        $orderTotal += $lineTotal;

                        echo "<tr>";
                        echo "<td>" . $detail['name'] . "</td>";
                        echo "<td>" . $detail['price'] . "</td>";
                        echo "<td>" . $detail['quantity'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan=3>No items found for this order.</td></tr>";
                }
                ?>
            </table>

            <p><strong>Order Total: RM <?php echo number_format($orderTotal, 2); ?></strong></p>
        </details>
        <?php
    }
}
mysqli_close($conn);
?>