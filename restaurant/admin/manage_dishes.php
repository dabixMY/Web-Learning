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

$uploadDir = '../images/';
$allowedExtensions = ['png', 'jpg', 'jpeg'];
$maxFileSize = 2 * 1024 * 1024;

$action = $_GET['action'] ?? 'list';
$errors = [];
function handleImageUpload($fieldName, $uploadDir, $allowedExtensions, $maxFileSize, &$errors)
{
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        $errors['image'] = 'Image is required.';
        return null;
    }

    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        $errors['image'] = 'Image upload failed. Please try again.';
        return null;
    }

    $extension = strtolower(pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions, true)) {
        $errors['image'] = 'Image must be a .png, .jpg or .jpeg file.';
        return null;
    }

    if ($_FILES[$fieldName]['size'] > $maxFileSize) {
        $errors['image'] = 'Image must be 2MB or smaller.';
        return null;
    }

    if (!is_dir($uploadDir)) {
        $errors['image'] = 'Upload folder not found.';
        return null;
    }

    $uniqueName = uniqid('dish_', true) . '.' . $extension;

    if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $uploadDir . $uniqueName)) {
        $errors['image'] = 'Could not save the uploaded image.';
        return null;
    }

    return $uniqueName;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Dishes</title>
    <link rel="stylesheet" href="../mystyle.css">
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <div id="contentWrapper" class="content">

        <h2>Manage Dishes</h2>

        <?php
        if ($action == 'add') {
            $name = $description = $price = $category = '';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $price = trim($_POST['price'] ?? '');
                $category = trim($_POST['category'] ?? '');

                if ($name === '') {
                    $errors['name'] = 'Dish name is required.';
                }

                if ($description === '') {
                    $errors['description'] = 'Description is required.';
                }

                if ($price === '') {
                    $errors['price'] = 'Price is required.';
                } elseif (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
                    $errors['price'] = 'Enter a valid price (e.g. 12.90).';
                }

                if ($category === '') {
                    $errors['category'] = 'Category is required.';
                }

                $imagePath = handleImageUpload('image', $uploadDir, $allowedExtensions, $maxFileSize, $errors);

                if (empty($errors)) {
                    $escName = mysqli_real_escape_string($conn, $name);
                    $escDescription = mysqli_real_escape_string($conn, $description);
                    $escPrice = mysqli_real_escape_string($conn, $price);
                    $escImage = mysqli_real_escape_string($conn, $imagePath);
                    $escCategory = mysqli_real_escape_string($conn, $category);

                    $sql = "INSERT INTO dishes (name, description, price, image, category) VALUES ('$escName', '$escDescription', '$escPrice', '$escImage', '$escCategory')";

                    if (mysqli_query($conn, $sql)) {
                        echo '<p>Dish added successfully.</p>';
                    } else {
                        echo '<p>Failed to add dish.</p>';
                    }
                }
            }

            if ($_SERVER['REQUEST_METHOD'] != 'POST' || !empty($errors)) {
                ?>
                <form id="dishForm" action="manage_dishes.php?action=add" method="post" enctype="multipart/form-data">
                    Name<br>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                    <div id="nameError" class="error"><?php echo $errors['name'] ?? ''; ?></div><br>

                    Description<br>
                    <textarea id="description" name="description" rows="4"
                        cols="40"><?php echo htmlspecialchars($description); ?></textarea>
                    <div id="descriptionError" class="error"><?php echo $errors['description'] ?? ''; ?></div><br>

                    Price (RM)<br>
                    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
                    <div id="priceError" class="error"><?php echo $errors['price'] ?? ''; ?></div><br>

                    Image (.png, .jpg, .jpeg - max 2MB)<br>
                    <input type="file" id="image" name="image" accept=".png,.jpg,.jpeg">
                    <div id="imageError" class="error"><?php echo $errors['image'] ?? ''; ?></div><br>

                    Category<br>
                    <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>">
                    <div id="categoryError" class="error"><?php echo $errors['category'] ?? ''; ?></div><br>

                    <input type="button" value="Add Dish" onclick="validateDishForm()">
                </form>
                <?php
            }
            ?>
            <p><a href='manage_dishes.php'>Back to dish list</a></p>
            <?php
        } elseif ($action == 'edit') {
            $id = $_GET['id'] ?? ($_POST['dish_id'] ?? 0);
            $name = $description = $price = $category = '';
            $currentImage = '';

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                $sql = "SELECT * FROM dishes WHERE dish_id=$id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                if (!$row) {
                    echo '<p>Dish not found.</p>';
                } else {
                    $name = $row['name'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $category = $row['category'];
                    $currentImage = $row['image'];
                }
            } else {
                $id = $_POST['dish_id'];
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $price = trim($_POST['price'] ?? '');
                $category = trim($_POST['category'] ?? '');
                $currentImage = $_POST['current_image'] ?? '';

                if ($id <= 0) {
                    $errors['id'] = 'Invalid dish id.';
                }

                if ($name === '') {
                    $errors['name'] = 'Dish name is required.';
                }

                if ($description === '') {
                    $errors['description'] = 'Description is required.';
                }

                if ($price === '') {
                    $errors['price'] = 'Price is required.';
                } elseif (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
                    $errors['price'] = 'Enter a valid price (e.g. 12.90).';
                }

                if ($category === '') {
                    $errors['category'] = 'Category is required.';
                }

                if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $imagePath = handleImageUpload('image', $uploadDir, $allowedExtensions, $maxFileSize, $errors);
                } else {
                    $imagePath = $currentImage;
                }

                if (empty($errors)) {
                    $escName = mysqli_real_escape_string($conn, $name);
                    $escDescription = mysqli_real_escape_string($conn, $description);
                    $escPrice = mysqli_real_escape_string($conn, $price);
                    $escImage = mysqli_real_escape_string($conn, $imagePath);
                    $escCategory = mysqli_real_escape_string($conn, $category);

                    $sql = "UPDATE dishes SET name='$escName', description='$escDescription', price='$escPrice', image='$escImage', category='$escCategory' WHERE dish_id=$id";

                    if (mysqli_query($conn, $sql)) {
                        if ($imagePath !== $currentImage && !empty($currentImage)) {
                            $oldFilePath = __DIR__ . '/../images/' . $currentImage;
                            $oldFilePath = str_replace('\\', '/', $oldFilePath);

                            if (file_exists($oldFilePath)) {
                                if (!unlink($oldFilePath)) {
                                    error_log("Failed to delete: " . $oldFilePath);
                                }
                            } else {
                                error_log("File not found: " . $oldFilePath);
                            }
                        }
                        echo '<p>Dish updated successfully.</p>';
                    } else {
                        echo '<p>Failed to update dish.</p>';
                    }
                }
            }

            if ($_SERVER['REQUEST_METHOD'] != 'POST' || !empty($errors)) {
                ?>
                <form id="dishForm" action="manage_dishes.php?action=edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="dish_id" value="<?php echo (int) $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($currentImage); ?>">

                    Name<br>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                    <div id="nameError" class="error"><?php echo $errors['name'] ?? ''; ?></div><br>

                    Description<br>
                    <textarea id="description" name="description" rows="4"
                        cols="40"><?php echo htmlspecialchars($description); ?></textarea>
                    <div id="descriptionError" class="error"><?php echo $errors['description'] ?? ''; ?></div><br>

                    Price (RM)<br>
                    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
                    <div id="priceError" class="error"><?php echo $errors['price'] ?? ''; ?></div><br>

                    <?php if ($currentImage !== '') { ?>
                        Current image:<br>
						<div class = "current-image-wrap">
                        <img src="../images/<?php echo htmlspecialchars($currentImage); ?>" width="120" class="current-dish-image">
						</div>
                    <?php } ?>
                    Replace image (.png, .jpg, .jpeg - max 2MB, leave blank to keep current)<br>
                    <input type="file" id="image" name="image" accept=".png,.jpg,.jpeg">
                    <div id="imageError" class="error"><?php echo $errors['image'] ?? ''; ?></div><br>

                    Category<br>
                    <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>">
                    <div id="categoryError" class="error"><?php echo $errors['category'] ?? ''; ?></div><br>

                    <input type="button" value="Update Dish" onclick="validateDishForm(true)">
                </form>
                <?php
            }
            ?>
            <p><a href='manage_dishes.php'>Back to dish list</a></p>
            <?php
        } elseif ($action == 'delete') {
            $id = $_GET['id'] ?? 0;

            if (!is_numeric($id) || $id <= 0) {
                echo '<p>Invalid dish id.</p>';
            } else {
                $sql = "DELETE FROM dishes WHERE dish_id = $id";

                if (mysqli_query($conn, $sql)) {
                    echo '<p>Dish deleted successfully.</p>';
                } else {
                    echo '<p>Dish not found or could not be deleted.</p>';
                }
            }
            ?>
            <p><a href='manage_dishes.php'>Back to dish list</a></p>
            <?php
        } else {
            ?>
            <p><a class="add-dish-btn" href="manage_dishes.php?action=add">+ Add New Dish</a></p>

            <?php
            $sql = "SELECT * FROM dishes ORDER BY dish_id ASC";
            $result = mysqli_query($conn, $sql);

            if (!$result || mysqli_num_rows($result) === 0) {
                echo '<p>No dishes found.</p>';
            } else {
                echo "<table id='dishTable'>";
                echo "<tr>";
                echo "<th>Name</th><th>Description</th><th>Price (RM)</th><th>Image</th><th>Category</th><th colspan=2>Actions</th>";
                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td><img src='../images/" . htmlspecialchars($row['image']) . "' width='180' height='180'></td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td><a class='action-link' href='manage_dishes.php?action=edit&id=" . $row['dish_id'] . "'>Edit</a></td>";
                    echo "<td><a class='action-link' href='manage_dishes.php?action=delete&id=" . $row['dish_id'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }

        mysqli_close($conn);
        ?>

    </div>

    <?php include('../includes/footer.php'); ?>

    <script>
        function validateDishForm(isEdit) {
            var isValid = true;
            var form = document.getElementById('dishForm');

            document.querySelectorAll('#dishForm div').forEach(function (div) {
                div.textContent = '';
            });

            if (form['name'].value.trim() === '') {
                document.getElementById('nameError').textContent = 'Dish name is required.';
                isValid = false;
            }

            if (form['description'].value.trim() === '') {
                document.getElementById('descriptionError').textContent = 'Description is required.';
                isValid = false;
            }

            let pricePattern = /^\d+(\.\d{1,2})?$/;
            if (form['price'].value.trim() === '') {
                document.getElementById('priceError').textContent = 'Price is required.';
                isValid = false;
            } else if (!pricePattern.test(form['price'].value.trim())) {
                document.getElementById('priceError').textContent = 'Enter a valid price (e.g. 12.90).';
                isValid = false;
            }

            let imageFiles = form['image'].files;
            let allowedExtensions = /\.(png|jpg|jpeg)$/i;
            let maxFileSize = 2 * 1024 * 1024;

            if (imageFiles.length === 0) {
                if (!isEdit) {
                    document.getElementById('imageError').textContent = 'Image is required.';
                    isValid = false;
                }
            } else {
                if (!allowedExtensions.test(imageFiles[0].name)) {
                    document.getElementById('imageError').textContent = 'Image must be a .png, .jpg or .jpeg file.';
                    isValid = false;
                } else if (imageFiles[0].size > maxFileSize) {
                    document.getElementById('imageError').textContent = 'Image must be 2MB or smaller.';
                    isValid = false;
                }
            }

            if (form['category'].value.trim() === '') {
                document.getElementById('categoryError').textContent = 'Category is required.';
                isValid = false;
            }

            if (isValid == true) {
                form.submit();
            }
        }
    </script>

</body>

</html>