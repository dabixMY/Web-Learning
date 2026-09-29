<html>
<head>
    <title>Contact Table</title>
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            background-color: white;
        }

        caption {
            caption-side: top;
            font-style: italic;
            font-size: 20px;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: red;
            color: white;
            font-weight: bold;
        }

        tbody tr:nth-child(odd) {
            background-color: white;
        }

        tbody tr:nth-child(even) {
            background-color: lightgray;
        }

        tbody tr:last-child {
            border-bottom: 3px solid red;
        }
    </style>
</head>
<body>
<?php
$contacts = [
    ['name' => 'Chia Kim Hooi', 'phone' => '+60124044404', 'email' => 'chiakh@duck.com', 'facebook' => 'xyz.chiakl'],
    ['name' => 'Chan Xiao Hui', 'phone' => '+60125785678', 'email' => 'chanxh@pingguo.com', 'facebook' => 'pqr.ch'],
    ['name' => 'Tan Chin Tiong', 'phone' => '+60193163616', 'email' => 'tanct@burungtiong.com', 'facebook' => 'abc'],
    ['name' => 'Foo Yoke Wai', 'phone' => '+60125755552', 'email' => 'fooyw@chicken.com', 'facebook' => 'ijk.fooyw'],
    ['name' => 'Ho Xin Yi', 'phone' => '+60195889776', 'email' => 'hoxy@myna.com', 'facebook' => 'mno.hoxy'],
    ['name' => 'Desmond Tay Qi Shun', 'phone' => '+60197989474', 'email' => 'desmond1231@1utar.my', 'facebook' => 'profile.php?id=100078255764070']
];

echo "<table>"; // Start of table
echo "<thead><tr><th>No</th><th>Name</th><th>Phone</th><th>Email</th><th>Facebook</th></tr></thead>";
echo "<tbody>";
$count = 1; // Initialize counter for the first column of numbers

foreach ($contacts as $contact) {
    echo "<tr>";
    echo "<td>" . $count++ . "</td>";
    echo "<td>" . htmlspecialchars($contact['name']) . "</td>";
    echo "<td>" . htmlspecialchars($contact['phone']) . "</td>";
    echo "<td><a href='mailto:" . htmlspecialchars($contact['email']) . "'>" . htmlspecialchars($contact['email']) . "</a></td>";
    echo "<td><a href='https://www.facebook.com/" . htmlspecialchars($contact['facebook']) . "' target='_blank'>" . htmlspecialchars($contact['facebook']) . "</a></td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
?>
</body>
</html>