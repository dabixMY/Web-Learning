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
    <div id="tableContainer"></div>
    <script>
        var parking = [
            {
                vehicleNo: "WYR9941",
                driver: "Tham Mun Fatt",
                block: "E",
                floor: "2",
                bay: 11
            },
            {
                vehicleNo: "PKC7453",
                driver: "Chia Kim Hooi",
                block: "C",
                floor: "3A",
                bay: 15
            },
            {
                vehicleNo: "WC852E",
                driver: "Ho Jo Ee",
                block: "E",
                floor: "G",
                bay: 34
            },
            {
                vehicleNo: "AGP8681",
                driver: "Foo Yoke Wai",
                block: "C",
                floor: "3A",
                bay: 19
            },
            {
                vehicleNo: "WA1368Y",
                driver: "Wong Pei Lin",
                block: "A",
                floor: "1",
                bay: 1
            },
            {
                vehicleNo: "WVV6707",
                driver: "Desmond Tay Qi Shun",
                block: "D3",
                floor: "11",
                bay: 2
            },
        ];
        var titles = ['Vehicle No', 'Driver', 'Block', 'Floor', 'Bay'];
        function generateTable() {
            // Create table element
            var table = document.createElement("table");

            // Caption
            var caption = document.createElement("caption");
            caption.textContent = "Parking List";
            table.appendChild(caption);

            // Header
            var thead = document.createElement("thead");
            var tr = document.createElement("tr");

            titles.forEach(function (title) {
                var th = document.createElement("th");
                th.textContent = title;
                tr.appendChild(th);
            });
            thead.appendChild(tr);
            table.appendChild(thead);

            // Body
            var tbody = document.createElement("tbody");

            parking.forEach(function (car) {
                var tr = document.createElement("tr");
                [
                    car.vehicleNo,
                    car.driver,
                    car.block,
                    car.floor,
                    car.bay
                ].forEach(function (value) {
                    var td = document.createElement("td");
                    td.textContent = value;
                    tr.appendChild(td);
                });
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            document.getElementById("tableContainer").appendChild(table);
        }
        window.onload = generateTable;
    </script>
</body>

</html>