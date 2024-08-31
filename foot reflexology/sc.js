// Simulated list of existing users
const existingUsers = [
    { username: 'user1', email: 'user1@example.com' },
    { username: 'user2', email: 'user2@example.com' }
];

// Function to validate email address
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Function to validate password strength
function isStrongPassword(password) {
    return password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password);
}

// Function to check if username or email is already taken
function isUserAlreadyRegistered(username, email) {
    return existingUsers.some(user => user.username === username || user.email === email);
}

// Function to handle form submission
function handleFormSubmit(event) {
    event.preventDefault(); // Prevent the default form submission

    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    // Clear previous error messages
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.textContent = '');

    let hasError = false;

    // Validate username
    if (username === '') {
        document.getElementById('username-error').textContent = 'Username is required.';
        hasError = true;
    }

    // Validate email
    if (email === '') {
        document.getElementById('email-error').textContent = 'Email is required.';
        hasError = true;
    } else if (!isValidEmail(email)) {
        document.getElementById('email-error').textContent = 'Invalid email format.';
        hasError = true;
    }

    // Validate password
    if (password === '') {
        document.getElementById('password-error').textContent = 'Password is required.';
        hasError = true;
    } else if (!isStrongPassword(password)) {
        document.getElementById('password-error').textContent = 'Password must be at least 8 characters long and include an uppercase letter and a number.';
        hasError = true;
    }

    // Validate confirm password
    if (confirmPassword === '') {
        document.getElementById('confirm-password-error').textContent = 'Please confirm your password.';
        hasError = true;
    } else if (password !== confirmPassword) {
        document.getElementById('confirm-password-error').textContent = 'Passwords do not match.';
        hasError = true;
    }

    // Check if username or email is already taken
    if (isUserAlreadyRegistered(username, email)) {
        document.getElementById('username-error').textContent = 'Username or email is already registered.';
        hasError = true;
    }

    // If there are no errors, show an alert message
    if (!hasError) {
        alert('Registration successful!');
        // Optionally, submit the form here if needed
        // document.getElementById('register-form').submit();
    }
}

// Attach event listener to the form
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('register-form');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
});
