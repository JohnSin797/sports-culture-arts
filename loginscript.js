document.addEventListener("DOMContentLoaded", function() {
    var form = document.forms["LoginForm"];
    if (form) {
        form.addEventListener("submit", function(event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        });
    }
});

function validateForm() {
    const form = document.forms["LoginForm"];
    if (!form) {
        console.error("Form 'LoginForm' not found.");
        return false;
    }

    const username = form["username"] ? form["username"].value.trim() : "";
    const password = form["password"] ? form["password"].value.trim() : "";
    let isValid = true;

    if (username === "") {
        showErrorMessage("username", "Please enter a Username/Student ID");
        isValid = false;
    } else {
        hideErrorMessage("username");
    }

    if (password === "") {
        showErrorMessage("password", "Please enter a password");
        isValid = false;
    } else {
        hideErrorMessage("password");
    }

    if (password.length < 8) {
        showErrorMessage("password-length", "Password must be at least 8 characters long");
        isValid = false;
    } else {
        hideErrorMessage("password-length");
    }

    return isValid;
}

document.addEventListener("DOMContentLoaded", function() {
    const form = document.forms["LoginForm"];
    const passwordInput = document.querySelector('.input-password');
    const showIcon = document.getElementById('show-icon');
    const hideIcon = document.getElementById('hide-icon');

    if (form) {
        form.addEventListener("submit", function(event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        });
    }

 // loginscript.js

function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const showIcon = document.getElementById('show-icon');
    const hideIcon = document.getElementById('hide-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showIcon.style.display = 'none';
        hideIcon.style.display = 'inline';
    } else {
        passwordInput.type = 'password';
        showIcon.style.display = 'inline';
        hideIcon.style.display = 'none';
    }
}
showIcon.addEventListener('click', togglePasswordVisibility);
hideIcon.addEventListener('click', togglePasswordVisibility);
// Initially hide the hide-icon
document.getElementById('hide-icon').style.display = 'none';

});
