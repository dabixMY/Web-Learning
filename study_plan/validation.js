document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let isValid = true;

        // Clear previous error messages
        document.getElementById("nameError").textContent = "";
        document.getElementById("emailError").textContent = "";
        document.getElementById("idError").textContent = "";
        document.getElementById("passwordError").textContent = "";

        const fullName = document.getElementById("full_name").value.trim();
        const email = document.getElementById("email").value.trim();
        const studentId = document.getElementById("student_id").value.trim();
        const password = document.getElementById("password").value;

        // All fields filled out
        if (fullName === "") {
            document.getElementById("nameError").textContent = "Full Name is required.";
            isValid = false;
        }

        // Valid email format
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "" || !emailPattern.test(email)) {
            document.getElementById("emailError").textContent = "Please enter a valid email address.";
            isValid = false;
        }

        // Student ID must be numeric, exactly 7 digits
        const idPattern = /^\d{7}$/;
        if (studentId === "" || !idPattern.test(studentId)) {
            document.getElementById("idError").textContent = "Student ID must be exactly 7 digits.";
            isValid = false;
        }

        // Password at least 6 characters
        if (password === "" || password.length < 6) {
            document.getElementById("passwordError").textContent = "Password must be at least 6 characters long.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});