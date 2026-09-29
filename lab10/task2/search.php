<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "w3resour_bookinfo2", 3308);

// Get the search term from the query string
$book = $_GET['book'];

// Select books whose names contain the search term
$sql = "SELECT * FROM book_mast
        WHERE book_name LIKE '%$book%'";

// Run the SQL query
$result = mysqli_query($conn, $sql);

// Display each matching book name + ISBN in a table
echo "<table>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>";
    echo $row['book_name'];
    echo "</td>";
    echo "<td>";
    echo $row['isbn_no'];
    echo "</td></tr>";
}
echo "</table>";