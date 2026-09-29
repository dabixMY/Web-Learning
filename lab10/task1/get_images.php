<?php

$folder = "images/"; // Image folder pic1.jpg
$files = scandir($folder); // Get files

foreach ($files as $file) {

    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Get extension

    if (
        $extension == "jpg" ||
        $extension == "jpeg" ||
        $extension == "png" ||
        $extension == "gif"
    ) {

        // Display supported images
        echo "<a href='image_details.php?image=$file'>";
        echo "<img src='images/$file'>";
        echo "</a>";
    }
}