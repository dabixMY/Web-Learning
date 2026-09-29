<html>

<head>
    <title>Parking Table</title>
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

        th,
        td {
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
    $parking = [
        ['vehicleNo' => 'WYR9941', 'driver' => 'Tham Mun Fatt', 'block' => 'E', 'floor' => '2', 'bay' => 11],
        ['vehicleNo' => 'PKC7453', 'driver' => 'Chia Kim Hooi', 'block' => 'C', 'floor' => '3A', 'bay' => 15],
        ['vehicleNo' => 'WCB852E', 'driver' => 'Ho Jo Ee', 'block' => 'E', 'floor' => 'G', 'bay' => 34],
        ['vehicleNo' => 'AGP8681', 'driver' => 'Foo Yoke Wai', 'block' => 'C', 'floor' => '3A', 'bay' => 19],
        ['vehicleNo' => 'WA1368Y', 'driver' => 'Wong Pei Lin', 'block' => 'A', 'floor' => '1', 'bay' => 1],
        ['vehicleNo' => 'WVV6707', 'driver' => 'Desmond Tay Qi Shun', 'block' => 'D3', 'floor' => '11', 'bay' => 2],
    ];

    echo "<table>"; // Start of the table
    echo "<caption><i>Parking Allocation at Pusat Dagangan Burung Tiong</i></caption>";
    echo "<thead><tr><th>Vehicle No</th><th>Driver</th><th>Block</th><th>Floor</th><th>Bay</th></tr></thead>";
    echo "<tbody>";
    foreach ($parking as $slot) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($slot['vehicleNo']) . "</td>";
        echo "<td>" . htmlspecialchars($slot['driver']) . "</td>";
        echo "<td>" . htmlspecialchars($slot['block']) . "</td>";
        echo "<td>" . htmlspecialchars($slot['floor']) . "</td>";
        echo "<td>" . htmlspecialchars($slot['bay']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>"; // End of the table
    ?>
</body>

</html>