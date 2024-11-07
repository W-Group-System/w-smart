document.addEventListener("DOMContentLoaded", function () {
    function handleLogin(event) {
        event.preventDefault();
        console.log("hello");

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        let valid = true;

        if (!email || !email.includes("@")) {
            document.getElementById("emailError").classList.remove("d-none");
            valid = false;
            console.log("Invalid email");
        } else {
            document.getElementById("emailError").classList.add("d-none");
        }

        if (!password) {
            document.getElementById("passwordError").classList.remove("d-none");
            valid = false;
            console.log("Password is required");
        } else {
            document.getElementById("passwordError").classList.add("d-none");
        }

        if (valid) {
            console.log("Login successful, redirecting to dashboard");
            window.location.href = "/dashboard";
        }
    }

    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", handleLogin);
    }
});
