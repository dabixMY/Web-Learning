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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $allowedStatuses = ['Pending', 'Completed', 'Cancelled'];

    if ($order_id > 0 && in_array($status, $allowedStatuses, true)) {
        $sql = "UPDATE orders SET status='$status' WHERE order_id=$order_id";
        mysqli_query($conn, $sql);
    }
}

$statusFilter = $_GET['status'] ?? 'All';
$allowedFilters = ['All', 'Pending', 'Completed', 'Cancelled'];
if (!in_array($statusFilter, $allowedFilters, true)) {
    $statusFilter = 'All';
}

$totalCount = 0;
$pendingCount = 0;
$completedCount = 0;
$cancelledCount = 0;

$countResult = mysqli_query($conn, "SELECT status, COUNT(*) AS total FROM orders GROUP BY status");
if ($countResult) {
    while ($countRow = mysqli_fetch_assoc($countResult)) {
        $totalCount += $countRow['total'];
        if ($countRow['status'] === 'Pending') {
            $pendingCount = $countRow['total'];
        } elseif ($countRow['status'] === 'Completed') {
            $completedCount = $countRow['total'];
        } elseif ($countRow['status'] === 'Cancelled') {
            $cancelledCount = $countRow['total'];
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../mystyle.css">
</head>

<body onload="searchOrders()">

    <?php include('../includes/header.php'); ?>

    <div id="contentWrapper" class="content">

        <h2>Manage Orders</h2>

        <div class="summary-cards">
            <div class="summary-card total">
                <span class="count"><?php echo $totalCount; ?></span>
                Total Orders
            </div>
            <div class="summary-card pending">
                <span class="count"><?php echo $pendingCount; ?></span>
                Pending
            </div>
            <div class="summary-card completed">
                <span class="count"><?php echo $completedCount; ?></span>
                Completed
            </div>
            <div class="summary-card cancelled">
                <span class="count"><?php echo $cancelledCount; ?></span>
                Cancelled
            </div>
        </div>

        <div class="filter-tabs">
            <?php foreach ($allowedFilters as $filterOption) { ?>
                <a class="<?php echo $statusFilter === $filterOption ? 'active' : ''; ?>"
                    href="manage_orders.php?status=<?php echo $filterOption; ?>">
                    <?php echo $filterOption; ?>
                </a>
            <?php } ?>
        </div>

        <form class="search-form" onsubmit="event.preventDefault();">
            <input type="hidden" id="status" value="<?php echo htmlspecialchars($statusFilter); ?>">
            <input type="text" id="search" onkeyup="searchOrders()" placeholder="Search by name, phone, or order ID">
        </form>

        <div id="order_list">
            <!-- Orders will be loaded here dynamically -->
        </div>

    </div>

    <?php include('../includes/footer.php'); ?>

    <script>
        function searchOrders() {
            var text = document.getElementById("search").value;
            var status = document.getElementById("status").value;
            var ajax = new XMLHttpRequest();

            ajax.open("GET", "search_orders.php?status=" + encodeURIComponent(status) + "&search=" + encodeURIComponent(text), true);
            ajax.send();

            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    document.getElementById("order_list").innerHTML = ajax.responseText;
                }
            };
        }
    </script>

</body>

</html>
<?php mysqli_close($conn); ?>