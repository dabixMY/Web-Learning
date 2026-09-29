
<?php

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'cafe_data';
$port = 3308;

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


/* Get dish ID from URL */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid dish ID.");
}

$dish_id = (int) $_GET['id'];


/* Get dish information from database */

$sql = "SELECT * FROM dishes WHERE dish_id = $dish_id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}


/* Check whether dish exists */

if (mysqli_num_rows($result) == 0) {
    die("Dish not found.");
}

$dish = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>

    <title>
        <?php echo htmlspecialchars($dish['name']); ?> - Plate & Co. Cafe
    </title>

    <link rel="stylesheet" href="/restaurant/mystyle.css">

</head>


<body>


<?php include('../includes/header.php'); ?>


<div id="itemDetailsPage">

    <a href="menu.php" class="backMenuBtn">
        ← Back to Menu
    </a>


    <div class="itemDetailsContainer">


        <!-- Food Image -->

        <div class="itemDetailsImage">

            <?php if (!empty($dish['image'])) { ?>

                <img
                    src="/restaurant/images/<?php echo htmlspecialchars($dish['image']); ?>"
                    alt="<?php echo htmlspecialchars($dish['name']); ?>"
                >

            <?php } else { ?>

                <p>No image available.</p>

            <?php } ?>

        </div>



        <!-- Food Information -->

        <div class="itemDetailsInfo">

            <p class="itemCategory">
                <?php echo htmlspecialchars($dish['category']); ?>
            </p>


            <h1>
                <?php echo htmlspecialchars($dish['name']); ?>
            </h1>


            <p class="itemPrice">
                RM <?php echo number_format($dish['price'], 2); ?>
            </p>


            <p class="itemDescription">
                <?php echo nl2br(htmlspecialchars($dish['description'])); ?>
            </p>


            <form action="../cart/cart.php" method="post">

    <input type="hidden" name="action" value="add">

    <input
        type="hidden"
        name="dish_id"
        value="<?php echo $dish['dish_id']; ?>"
    >

    <div class="quantitySection">

        <label for="quantity">
            Quantity:
        </label>

        <input
            type="number"
            id="quantity"
            name="quantity"
            value="1"
            min="1"
            max="20"
        >

    </div>

    <button type="submit" class="addCartBtn">
        Add to Cart
    </button>

</form>

        </div>

    </div>

</div>


<?php include('../includes/footer.php'); ?>


</body>

</html>


<?php

mysqli_close($conn);

?>

