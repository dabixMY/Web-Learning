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

$action = $_GET['action'] ?? 'list';

if ($action == 'delete') {
    $id = $_GET['id'] ?? 0;

    if (!is_numeric($id) || $id <= 0) {
        $deleteError = 'Invalid contact message id.';
    } else {
        $sql = "DELETE FROM contact WHERE contact_id = $id";
        mysqli_query($conn, $sql);
    }
}

function buildWhatsAppLink($phone)
{
    $digits = str_replace([' ', '-', '(', ')', '+'], '', $phone);
    $digits = preg_replace('/[^0-9]/', '', $digits);

    if (substr($digits, 0, 1) === '0') {
        $digits = '6' . $digits;
    }

    return 'https://wa.me/' . $digits;
}

$typeFilter = $_GET['type'] ?? 'All';
$allowedFilters = ['All', 'Praise', 'Complaint', 'Suggestions'];
if (!in_array($typeFilter, $allowedFilters, true)) {
    $typeFilter = 'All';
}

$totalCount = 0;
$praiseCount = 0;
$complaintCount = 0;
$suggestionsCount = 0;

$countResult = mysqli_query($conn, "SELECT enquiry_type, COUNT(*) AS total FROM contact GROUP BY enquiry_type");
if ($countResult) {
    while ($countRow = mysqli_fetch_assoc($countResult)) {
        $totalCount += $countRow['total'];
        if ($countRow['enquiry_type'] === 'Praise') {
            $praiseCount = $countRow['total'];
        } elseif ($countRow['enquiry_type'] === 'Complaint') {
            $complaintCount = $countRow['total'];
        } elseif ($countRow['enquiry_type'] === 'Suggestions') {
            $suggestionsCount = $countRow['total'];
        }
    }
}

$sql = "SELECT * FROM contact";
if ($typeFilter !== 'All') {
    $escType = mysqli_real_escape_string($conn, $typeFilter);
    $sql .= " WHERE enquiry_type = '$escType'";
}
$sql .= " ORDER BY created_at DESC";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Reviews</title>
    <link rel="stylesheet" href="../mystyle.css">
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <div id="contentWrapper" class="content">

        <h2>Manage Reviews</h2>

        <div class="summary-cards">
            <div class="summary-card total">
                <span class="count"><?php echo $totalCount; ?></span>
                Total
            </div>
            <div class="summary-card praise">
                <span class="count"><?php echo $praiseCount; ?></span>
                Praise
            </div>
            <div class="summary-card complaint">
                <span class="count"><?php echo $complaintCount; ?></span>
                Complaint
            </div>
            <div class="summary-card suggestions">
                <span class="count"><?php echo $suggestionsCount; ?></span>
                Suggestions
            </div>
        </div>

        <div class="filter-tabs">
            <?php foreach ($allowedFilters as $filterOption) { ?>
                <a class="<?php echo $typeFilter === $filterOption ? 'active' : ''; ?>"
                    href="manage_reviews.php?type=<?php echo $filterOption; ?>">
                    <?php echo $filterOption; ?>
                </a>
            <?php } ?>
        </div>

        <?php if (!empty($deleteError)) { ?>
            <p class="error"><?php echo $deleteError; ?></p>
        <?php } ?>

        <?php
        $result = mysqli_query($conn, $sql);

        if (!$result || mysqli_num_rows($result) === 0) {
            echo '<p>No reviews found.</p>';
        } else {
            echo "<table>";
            echo "<tr>";
            echo "<th>Name</th><th>Email</th><th>Phone</th><th>Type</th><th>Category</th><th>Message</th><th>Date</th><th>Actions</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                $friendlyDate = date('d M Y, g:i A', strtotime($row['created_at']));
                $category = $row['feedback_category'] ?? '-';
                $whatsAppLink = buildWhatsAppLink($row['phone']);
                $messagePreview = mb_substr($row['message'], 0, 40);
                if (mb_strlen($row['message']) > 40) {
                    $messagePreview .= '...';
                }

                echo "<tr>";
                echo "<td>" . $row['salutation'] . " " . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['enquiry_type'] . "</td>";
                echo "<td>" . $category . "</td>";
                echo "<td class='message-cell'><details><summary>" . $messagePreview . "</summary><p>" . $row['message'] . "</p></details></td>";
                echo "<td>" . $friendlyDate . "</td>";
                echo "<td>";
                echo "<a class='action-link' href='" . $whatsAppLink . "' target='_blank'>WhatsApp</a>";
                echo "<a class='action-link' href='mailto:" . $row['email'] . "'>Email</a>";
                echo "<a class='action-link' href='manage_reviews.php?action=delete&id=" . $row['contact_id'] . "'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        mysqli_close($conn);
        ?>

    </div>

    <?php include('../includes/footer.php'); ?>

</body>

</html>