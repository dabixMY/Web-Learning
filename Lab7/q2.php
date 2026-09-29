<?php

$properties = [
    [
        'unitNo' => 'C-8-1',
        'owner' => 'Foo Yoke Wai'
    ],
    [
        'unitNo' => 'C-3A-3A',
        'owner' => 'Chia Kim Hooi'
    ],
    [
        'unitNo' => 'B-18-8',
        'owner' => 'Heng Tee See'
    ],
    [
        'unitNo' => 'A-10-10',
        'owner' => 'Tang So Ny'
    ],
    [
        'unitNo' => 'B-19-10',
        'owner' => 'Tang Xiao Mi'
    ],
        [
        'unitNo' => 'D-12-31',
        'owner' => 'Desmond Tay Qi Shun'
    ]
];

echo "<ol>"; // Start of the ordered list
foreach ($properties as $property) {
    echo "<li>" . htmlspecialchars($property['unitNo']) . ": " . htmlspecialchars($property['owner']) . "</li>";
}
echo "</ol>"; // End of the ordered list

?>