<!DOCTYPE html>
<html>

<head>
    <title>Book Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
            color: #333;
        }

        #suggestions {
            background: white;
            border-radius: 4px;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <h1>Book Search</h1>

    <form>
        <input type="text" id="book" onkeyup="searchBook()" placeholder="Enter book title">

        <input type="submit" value="Search">
    </form>

    <div id="suggestions"></div>

</body>

</html>

<script>
    // Send AJAX request when typing in the search field
    function searchBook() {
        var text = document.getElementById("book").value;
        var ajax = new XMLHttpRequest();

        // Request matching books from search.php
        ajax.open("GET", "search.php?book=" + text, true);
        ajax.send();

        // Update suggestions when response is received
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                document.getElementById("suggestions").innerHTML = ajax.responseText;
            }
        };
    }
</script>