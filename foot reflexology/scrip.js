document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get user input values
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Simulate successful login
    // In a real application, you would validate the credentials here
    if (username && password) {
        // Redirect to the success page
        window.location.href = 'success.html';
    } else {
        alert('Please enter both username and password.');
    }
});
