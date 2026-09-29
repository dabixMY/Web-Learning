<?php
$members = array(
    "Tham Mun Fatt",
    "Tan Chin Tiong",
    "Apple Tiong",
    "Tiong Na Na",
    "Sam Sung",
    "Desmond Tay Qi Shun"
);

echo "<ul>"; // Start of the unordered list
foreach ($members as $member) {
    echo "<li>" . htmlspecialchars($member) . "</li>"; // Each member as a list item
}
echo "</ul>"; // End of the unordered list

?>