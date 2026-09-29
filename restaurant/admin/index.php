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

$totalDishes = 0;
$dishCategories = [];

$dishResult = mysqli_query($conn, "SELECT category, COUNT(*) AS total FROM dishes GROUP BY category");
if ($dishResult) {
    while ($row = mysqli_fetch_assoc($dishResult)) {
        $totalDishes += $row['total'];
        $dishCategories[$row['category']] = $row['total'];
    }
}

$totalOrders = 0;
$pendingCount = 0;
$completedCount = 0;
$cancelledCount = 0;

$orderResult = mysqli_query($conn, "SELECT status, COUNT(*) AS total FROM orders GROUP BY status");
if ($orderResult) {
    while ($row = mysqli_fetch_assoc($orderResult)) {
        $totalOrders += $row['total'];
        if ($row['status'] === 'Pending') {
            $pendingCount = $row['total'];
        } elseif ($row['status'] === 'Completed') {
            $completedCount = $row['total'];
        } elseif ($row['status'] === 'Cancelled') {
            $cancelledCount = $row['total'];
        }
    }
}

$totalReviews = 0;
$praiseCount = 0;
$complaintCount = 0;
$suggestionsCount = 0;

$reviewResult = mysqli_query($conn, "SELECT enquiry_type, COUNT(*) AS total FROM contact GROUP BY enquiry_type");
if ($reviewResult) {
    while ($row = mysqli_fetch_assoc($reviewResult)) {
        $totalReviews += $row['total'];
        if ($row['enquiry_type'] === 'Praise') {
            $praiseCount = $row['total'];
        } elseif ($row['enquiry_type'] === 'Complaint') {
            $complaintCount = $row['total'];
        } elseif ($row['enquiry_type'] === 'Suggestions') {
            $suggestionsCount = $row['total'];
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../mystyle.css">
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <div id="contentWrapper" class="content">

        <h2>Admin Dashboard</h2>

        <div class="dashboard-section">
            <h3>Dishes</h3>
            <div class="summary-cards">
                <a class="summary-card card-dishes-total" href="manage_dishes.php">
                    <span class="count"><?php echo $totalDishes; ?></span>
                    <span class="label">Total Dishes</span>
                </a>
            </div>
        </div>

        <div class="dashboard-section">
            <h3>Orders</h3>
            <div class="summary-cards">
                <a class="summary-card card-orders-total" href="manage_orders.php?status=All">
                    <span class="count"><?php echo $totalOrders; ?></span>
                    <span class="label">Total Orders</span>
                </a>
                <a class="summary-card card-orders-pending" href="manage_orders.php?status=Pending">
                    <span class="count"><?php echo $pendingCount; ?></span>
                    <span class="label">Pending</span>
                </a>
                <a class="summary-card card-orders-completed" href="manage_orders.php?status=Completed">
                    <span class="count"><?php echo $completedCount; ?></span>
                    <span class="label">Completed</span>
                </a>
                <a class="summary-card card-orders-cancelled" href="manage_orders.php?status=Cancelled">
                    <span class="count"><?php echo $cancelledCount; ?></span>
                    <span class="label">Cancelled</span>
                </a>
            </div>
        </div>

        <div class="dashboard-section">
            <h3>Reviews</h3>
            <div class="summary-cards">
                <a class="summary-card card-reviews-total" href="manage_reviews.php?type=All">
                    <span class="count"><?php echo $totalReviews; ?></span>
                    <span class="label">Total Reviews</span>
                </a>
                <a class="summary-card card-reviews-praise" href="manage_reviews.php?type=Praise">
                    <span class="count"><?php echo $praiseCount; ?></span>
                    <span class="label">Praise</span>
                </a>
                <a class="summary-card card-reviews-complaint" href="manage_reviews.php?type=Complaint">
                    <span class="count"><?php echo $complaintCount; ?></span>
                    <span class="label">Complaint</span>
                </a>
                <a class="summary-card card-reviews-suggestions" href="manage_reviews.php?type=Suggestions">
                    <span class="count"><?php echo $suggestionsCount; ?></span>
                    <span class="label">Suggestions</span>
                </a>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

</body>

</html>