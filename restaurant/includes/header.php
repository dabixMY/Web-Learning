<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header id="pageHeader">

    <div class="header-inner">

        <!-- Logo / Brand -->
        <a href="/restaurant/" class="brand">

            

            <div class="brand-text">
                <span class="brand-name">PLATE & CO.</span>
                <span class="brand-subtitle">CAFE</span>
            </div>

        </a>


        <!-- Navigation -->
        <nav class="main-nav">

            <ul>

                <li>
                    <a href="/restaurant/">Home</a>
                </li>

                <li>
                    <a href="/restaurant/menu/menu/">Menu</a>
                </li>

                <li>
                    <a href="/restaurant/cart/cart.php">Cart</a>
                </li>

                <li>
                    <a href="/restaurant/contact/">Contact</a>
                </li>


                <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>

                    <li class="admin-dropdown">

                        <a href="/restaurant/admin">
                            Admin
                            <span class="dropdown-arrow">⌄</span>
                        </a>

                        <ul class="admin-menu">

                            <li>
                                <a href="/restaurant/admin">
                                    Dashboard
                                </a>
                            </li>

                            <li>
                                <a href="/restaurant/admin/manage_dishes.php">
                                    Manage Dishes
                                </a>
                            </li>

                            <li>
                                <a href="/restaurant/admin/manage_orders.php">
                                    Manage Orders
                                </a>
                            </li>

                            <li>
                                <a href="/restaurant/admin/manage_reviews.php">
                                    Manage Reviews
                                </a>
                            </li>

                        </ul>

                    </li>

                <?php endif; ?>


                <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>

                    <li>
                        <a href="/restaurant/user/profile.php"
                           class="profile-link">
                            Profile
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </nav>

    </div>

</header>