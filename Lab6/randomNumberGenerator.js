var numbers = [];

function generateNumbers() {
    for (var i = 0; i < 5; i++) {
        numbers[i] = Math.floor(Math.random() * 100 + 1);
    }
    document.getElementById("result").innerHTML = "Generated Numbers : " + numbers.join(", ");
}

function findMax() {
    var max = Math.max(...numbers);
    document.getElementById("result").innerHTML = "Largest Numbers: " + max;
}

function findMin() {
    var min = Math.min(...numbers);
    document.getElementById("result").innerHTML = "Smallest Numbers: " + min;
}

