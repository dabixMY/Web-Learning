<div align="center">
    <?php
    // Display the page heading.
    echo "<h1>Image Details</h1>";

    // Check whether an image name was provided in the URL.
    if (isset($_GET['image'])) {

        // Store the requested image name.
        $image = $_GET['image'];

        // Check whether the requested image exists.
        if (file_exists("images/" . $image)) {
            // Display the image at a fixed width.
            echo "<img src='images/$image' width='800' align='center'>";
        } else {
            // Display an error when the image does not exist.
            echo "<p>Image not found.</p>";
        }
    } else {
        // Display an error when no image was requested.
        echo "<p>Image not found.</p>";
    }
    ?>
</div>