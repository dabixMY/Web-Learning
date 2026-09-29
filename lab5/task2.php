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
        var contacts = [
            {
                name: "Chia Kim Hooi",
                phone: "+60124044404",
                email: "chiakh@duck.com",
                facebook: "xyz.chiakh"
            },
            {
                name: "Chan Xiao Hui",
                phone: "+60125785678",
                email: "chanxh@pingguo.com",
                facebook: "pqr.chanxh"
            },
            {
                name: "Tan Chin Tiong",
                phone: "+60193163616",
                email: "tanct@burungtiong.com",
                facebook: "abc.tanct"
            },
            {
                name: "Foo Yoke Wai",
                phone: "+60125575552",
                email: "fooyw@chicken.com",
                facebook: "ijk.fooyw"
            },
            {
                name: "Ho Xin Yi",
                phone: "+60195889776",
                email: "hoxy@myna.com",
                facebook: "mno.hoxy"
            },
            {
                name: "Desmond Tay Qi Shun",
                phone: "+60197989474",
                email: "desmond1231@1utar.my",
                facebook: "profile.php?id=100078255764070"
            }
        ];
        var titles = ['No.', 'Name', 'Phone', 'Email', 'Facebook'];
        function generateTable() {
            // Create table element
            var table = document.createElement("table");

            // Caption
            var caption = document.createElement("caption");
            caption.textContent = "Contact List";
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
            var i = 1;
            contacts.forEach(contact => {
                var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.textContent = i++ + '.';
                tr.appendChild(td);

                var td = document.createElement('td');
                td.textContent = contact.name;
                tr.appendChild(td);

                var td = document.createElement('td');
                td.textContent = contact.phone;
                tr.appendChild(td);

                var td = document.createElement('td');
                var a = document.createElement('a');
                a.setAttribute('href', 'mailto:' + contact.email);
                a.textContent = contact.email;
                td.appendChild(a);
                tr.appendChild(td);

                var td = document.createElement('td');
                var a = document.createElement('a');
                a.setAttribute('href', 'https://www.facebook.com/' + contact.facebook);
                a.setAttribute('target', '_blank'); // Open in a new tab/window
                a.textContent = contact.facebook;
                td.appendChild(a);
                tr.appendChild(td);

                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            document.getElementById("tableContainer").appendChild(table);
        }
        window.onload = generateTable;
    </script>
</body>

</html>