<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Plate & Co. Cafe</title>
    <link rel="stylesheet" href="/restaurant/mystyle.css">
</head>

<body>

<?php include('includes/header.php'); ?>


<main>

    <!-- ==================== HERO ==================== -->
    <section class="hero">

        <img src="http://localhost/restaurant/banner2.jpg"
             alt="Plate & Co. Cafe"
             class="hero-image">

        <div class="hero-overlay">

            <p class="hero-label">WELCOME TO</p>

            <h1>PLATE & CO.</h1>

            <p class="hero-subtitle">
                Fresh food.<br>
                Good company.
            </p>

            <a href="menu/menu.php" class="hero-button">
                Explore Our Menu
            </a>

        </div>

    </section>


    <!-- ==================== INTRO ==================== -->
    <!-- ==================== OUR STORY ==================== -->
<section class="story-section">

    <div class="story-content">

        <p class="section-label">OUR STORY</p>

        <h2>
            Made with care,<br>
            served with heart.
        </h2>

        <p>
            Plate & Co. Cafe was created with a simple idea:
            good food brings people together. From comforting
            classics to freshly prepared favourites, we serve
            delicious food in a warm and welcoming space.
        </p>

        <p>
            Whether you're joining us for a quick coffee,
            a casual meal, or a gathering with friends,
            there's always a place for you at our table :)
        </p>

    </div>

</section>


    <!-- ==================== FEATURED DISHES ==================== -->
    <section class="featured-section">

        <div class="section-heading">

            <p class="section-label">FROM OUR KITCHEN</p>

            <h2>Featured Dishes</h2>

            <p>
                A few favourites from our kitchen.
            </p>

        </div>


        <div class="food-container">


            <!-- Burger -->
            <div class="food-card">

                <img src="images/burger.png"
                     alt="Classic Burger">

                <div class="food-info">

                    <h3>Classic Burger</h3>

                    <p class="food-description">
                        A juicy classic burger served with
                        fresh ingredients.
                    </p>

                    <p class="food-price">
                        RM 15.90
                    </p>

                </div>

            </div>


            <!-- Carbonara -->
            <div class="food-card">

                <img src="images/carbonara.png"
                     alt="Creamy Carbonara">

                <div class="food-info">

                    <h3>Creamy Carbonara</h3>

                    <p class="food-description">
                        Creamy pasta prepared with a rich
                        and comforting sauce.
                    </p>

                    <p class="food-price">
                        RM 18.90
                    </p>

                </div>

            </div>


            <!-- Steak -->
            <div class="food-card">

                <img src="images/steak.png"
                     alt="Grilled Steak">

                <div class="food-info">

                    <h3>Grilled Steak</h3>

                    <p class="food-description">
                        Tender grilled steak prepared
                        with care.
                    </p>

                    <p class="food-price">
                        RM 25.90
                    </p>

                </div>

            </div>


        </div>


        <a href="menu/menu.php" class="outline-button">
            View Full Menu
        </a>

    </section>


    <!-- ==================== PROMOTION ==================== -->
    <section class="promotion-section">

        <div class="promotion-content">

            <p class="section-label">
                OCTOBER SPECIAL
            </p>

            <h2>A Little Extra</h2>

            <p>
                Enjoy a free snack with every table order
                from Monday to Friday.
            </p>

            <p class="promotion-date">
                Available throughout October
            </p>

        </div>

    </section>


    <!-- ==================== VISIT US ==================== -->
    <!-- ==================== VISIT US ==================== -->
<section class="visit-section">

    <div class="visit-heading">

        <p class="section-label">
            COME & DINE WITH US
        </p>

        <h2>
            We'd love to<br>
            have you here.
        </h2>

    </div>


    <div class="visit-details">

        <!-- Opening Hours -->
        <div class="visit-item">

            <h3>Opening Hours</h3>

            <p>
                Monday – Friday<br>
                10:00 AM – 10:00 PM
            </p>

            <p>
                Saturday – Sunday<br>
                9:00 AM – 11:00 PM
            </p>

        </div>


        <!-- Location -->
        <div class="visit-item">

            <h3>Location</h3>

            <p>
                Plate & Co. Cafe<br>
                125 Cozy Street<br>
                Kuala Lumpur, Malaysia
            </p>

        </div>


        <!-- Contact -->
        <div class="visit-item">

            <h3>Contact</h3>

            <p>
                +60 10-438 8315<br>
                joejoe@plateandco.com
            </p>

            <a href="contact/" class="text-link">
                Get in touch →
            </a>

        </div>

    </div>

</section>


</main>


<?php include('includes/footer.php'); ?>

</body>
</html>