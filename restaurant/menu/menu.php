<?php

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'cafe_data';
$port = 3308;

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $port);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get all dishes
$sql = "SELECT * FROM dishes ORDER BY dish_id";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu - Plate & Co. Cafe</title>

    <link rel="stylesheet" href="/restaurant/mystyle.css">

</head>

<body>

<?php include('../includes/header.php'); ?>


<main id="menuPage">


    <!-- MENU HEADER -->

    <section class="menuHeader">

        <p class="section-label">
            PLATE &amp; CO. CAFE
        </p>

        <h1>
            Our Menu
        </h1>

        <p class="menuIntro">
            Freshly prepared dishes and handcrafted beverages.
        </p>

    </section>



    <!-- CATEGORY NAVIGATION -->

    <nav id="menuCategories">

        <button
            class="menuCategoryBtn active"
            onclick="filterSelection('all', this)">
            All
        </button>

        <button
            class="menuCategoryBtn"
            onclick="filterSelection('burger', this)">
            Burger
        </button>

        <button
            class="menuCategoryBtn"
            onclick="filterSelection('maincourse', this)">
            Main Course
        </button>

        <button
            class="menuCategoryBtn"
            onclick="filterSelection('pasta', this)">
            Pasta
        </button>

        <button
            class="menuCategoryBtn"
            onclick="filterSelection('snacks', this)">
            Snacks
        </button>

        <button
            class="menuCategoryBtn"
            onclick="filterSelection('beverages', this)">
            Beverages
        </button>

        <button
            class="menuCategoryBtn"
            onclick="filterSelection('desserts', this)">
            Desserts
        </button>

    </nav>



    <!-- MENU ITEMS -->

    <section class="menuList">

        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                // Convert category to lowercase
                $category = strtolower($row['category']);

                // Remove spaces
                $category = str_replace(' ', '', $category);

        ?>

        <article class="menuItem <?php echo $category; ?>">


            <!-- FOOD INFORMATION -->

            <div class="menuItemInfo">

                <a
                    href="/restaurant/menu/details.php?id=<?php echo $row['dish_id']; ?>"
                    class="menuItemLink"
                >

                    <div class="menuItemTitle">

                        <h2>
                            <?php echo htmlspecialchars($row['name']); ?>
                        </h2>

                        <span class="menuItemPrice">
                            RM <?php echo number_format($row['price'], 2); ?>
                        </span>

                    </div>

                </a>

            </div>



            <!-- FOOD IMAGE -->

            <?php if (!empty($row['image'])) { ?>

                <a
                    href="/restaurant/menu/details.php?id=<?php echo $row['dish_id']; ?>"
                    class="menuItemImage"
                >

                    <img
                        src="/restaurant/images/<?php echo htmlspecialchars($row['image']); ?>"
                        alt="<?php echo htmlspecialchars($row['name']); ?>"
                    >

                </a>

            <?php } ?>


        </article>


        <?php

            }

        } else {

            echo "<p class='noDishes'>No dishes available.</p>";

        }

        ?>

    </section>


</main>


<?php include('../includes/footer.php'); ?>


<script>

function filterSelection(category, button) {

    var foods = document.getElementsByClassName("menuItem");


    for (var i = 0; i < foods.length; i++) {

        if (category === "all") {

            foods[i].style.display = "flex";

        } else {

            if (foods[i].classList.contains(category)) {

                foods[i].style.display = "flex";

            } else {

                foods[i].style.display = "none";

            }

        }

    }


    // Change active category

    var buttons =
        document.getElementsByClassName("menuCategoryBtn");


    for (var i = 0; i < buttons.length; i++) {

        buttons[i].classList.remove("active");

    }


    button.classList.add("active");

}

</script>


</body>

</html>


<?php

mysqli_close($conn);

?>